<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Core\Database;
use App\Core\TenantContext;
use App\Models\ClassSchedule;
use App\Exceptions\ValidationException;

class ClassScheduleService extends Service
{
    private ClassSchedule $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ClassSchedule();
    }

    public function createSchedule(array $data, int $actorUserId, string $actorRole): int
    {
        $tid = TenantContext::getTenantId();
        $courseId = (int)($data['course_id'] ?? 0);
        $batchId = !empty($data['batch_id']) ? (int)$data['batch_id'] : null;
        $facultyId = !empty($data['faculty_id']) ? (int)$data['faculty_id'] : $actorUserId;
        $title = trim($data['title'] ?? '');
        $scheduleDate = trim($data['schedule_date'] ?? '');
        $startTime = trim($data['start_time'] ?? '');
        $endTime = trim($data['end_time'] ?? '');
        $provider = trim($data['meeting_provider'] ?? 'jitsi');
        $customLink = trim($data['meeting_link'] ?? '');

        if ($courseId <= 0) {
            throw new ValidationException(['course_id' => 'Please select a target course / subject.'], 'Please select a target course / subject.');
        }
        if (empty($title)) {
            throw new ValidationException(['title' => 'Class lecture title is required.'], 'Class lecture title is required.');
        }
        if (empty($scheduleDate) || empty($startTime) || empty($endTime)) {
            throw new ValidationException(['schedule_date' => 'Schedule date, start time, and end time are required.'], 'Schedule date, start time, and end time are required.');
        }

        // Role Permission Check: If faculty, verify they teach this course
        if ($actorRole === 'faculty' || $actorRole === 'instructor') {
            $isAssigned = Database::fetchOne(
                "SELECT 1 FROM course_instructors WHERE tenant_id = :tid AND course_id = :cid AND user_id = :uid LIMIT 1",
                ['tid' => $tid, 'cid' => $courseId, 'uid' => $actorUserId]
            );
            if (!$isAssigned) {
                // Also check if user is a tenant admin
                $isAdmin = Database::fetchOne(
                    "SELECT 1 FROM user_roles ur JOIN roles r ON ur.role_id = r.id WHERE ur.user_id = :uid AND r.name IN ('Super Admin', 'Admin', 'Tenant Admin') LIMIT 1",
                    ['uid' => $actorUserId]
                );
                if (!$isAdmin) {
                    throw new ValidationException(['permission' => 'You can only schedule classes for courses/batches assigned to you.'], 'You can only schedule classes for courses/batches assigned to you.');
                }
            }
            $facultyId = $actorUserId;
        }

        // Auto-generate Digital Room Link if using Jitsi and link is empty
        $meetingLink = $customLink;
        if (empty($meetingLink) && $provider === 'jitsi') {
            $roomCode = 'Tyche_Class_' . $tid . '_' . strtoupper(substr(md5(uniqid((string)time(), true)), 0, 8));
            $meetingLink = "https://meet.jit.si/" . $roomCode;
        }

        $createdByRole = ($actorRole === 'super_admin' || $actorRole === 'admin' || $actorRole === 'tenant_admin') ? 'admin' : 'faculty';

        $id = $this->scheduleModel->create([
            'course_id' => $courseId,
            'batch_id' => $batchId,
            'faculty_id' => $facultyId,
            'title' => $title,
            'description' => trim($data['description'] ?? ''),
            'schedule_date' => $scheduleDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'meeting_provider' => $provider,
            'meeting_link' => $meetingLink,
            'status' => 'scheduled',
            'created_by_role' => $createdByRole
        ]);

        // Auto-assign faculty to course_instructors if not already linked
        if ($facultyId > 0 && $courseId > 0) {
            $existsInst = Database::fetchOne(
                "SELECT 1 FROM course_instructors WHERE tenant_id = :tid AND course_id = :cid AND user_id = :fid LIMIT 1",
                ['tid' => $tid, 'cid' => $courseId, 'fid' => $facultyId]
            );
            if (!$existsInst) {
                Database::execute(
                    "INSERT INTO course_instructors (tenant_id, course_id, user_id, role) VALUES (:tid, :cid, :fid, 'instructor')",
                    ['tid' => $tid, 'cid' => $courseId, 'fid' => $facultyId]
                );
            }
        }

        return (int)$id;
    }

    public function toggleGoLive(int $scheduleId, int $actorUserId): array
    {
        $schedule = $this->scheduleModel->find($scheduleId);
        if (!$schedule) {
            throw new ValidationException(['schedule_id' => "Class schedule #{$scheduleId} not found."], "Class schedule #{$scheduleId} not found.");
        }

        $newStatus = ($schedule['status'] === 'live') ? 'completed' : 'live';

        // Auto-generate room link if missing when going live
        $meetingLink = $schedule['meeting_link'];
        if (empty($meetingLink)) {
            $tid = TenantContext::getTenantId();
            $roomCode = 'Tyche_Class_' . $tid . '_' . strtoupper(substr(md5(uniqid((string)time(), true)), 0, 8));
            $meetingLink = "https://meet.jit.si/" . $roomCode;
        }

        $this->scheduleModel->update($scheduleId, [
            'status' => $newStatus,
            'meeting_link' => $meetingLink
        ]);

        return [
            'status' => $newStatus,
            'meeting_link' => $meetingLink,
            'message' => ($newStatus === 'live') ? "Class is now LIVE! Digital Classroom Link broadcasted to batch." : "Class marked as Completed."
        ];
    }

    public function updateStatus(int $scheduleId, string $status): void
    {
        $valid = ['scheduled', 'live', 'completed', 'cancelled'];
        if (!in_array($status, $valid, true)) {
            throw new ValidationException(['status' => "Invalid status value."], "Invalid status value.");
        }

        $this->scheduleModel->update($scheduleId, ['status' => $status]);
    }
}
