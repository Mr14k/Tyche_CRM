<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class ClassSchedule extends Model
{
    protected string $table = 'class_schedules';

    public function find(int|string $id): ?array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT cs.*, c.title as course_title, c.code as course_code, 
                       b.batch_name, u.first_name as faculty_first, u.last_name as faculty_last
                FROM class_schedules cs
                JOIN courses c ON cs.course_id = c.id
                LEFT JOIN batches b ON cs.batch_id = b.id
                JOIN users u ON cs.faculty_id = u.id
                WHERE cs.id = :id AND cs.tenant_id = :tid LIMIT 1";
        
        return Database::fetchOne($sql, ['id' => (int)$id, 'tid' => $tid]) ?: null;
    }

    public function getFacultySchedules(int $facultyId, ?string $startDate = null, ?string $endDate = null): array
    {
        $tid = TenantContext::getTenantId();
        $params = ['fid' => $facultyId, 'tid' => $tid];
        $sql = "SELECT cs.*, c.title as course_title, c.code as course_code, 
                       b.batch_name, u.first_name as faculty_first, u.last_name as faculty_last
                FROM class_schedules cs
                JOIN courses c ON cs.course_id = c.id
                LEFT JOIN batches b ON cs.batch_id = b.id
                JOIN users u ON cs.faculty_id = u.id
                WHERE cs.tenant_id = :tid AND cs.faculty_id = :fid";

        if ($startDate && $endDate) {
            $sql .= " AND cs.schedule_date BETWEEN :start AND :end";
            $params['start'] = $startDate;
            $params['end'] = $endDate;
        }

        $sql .= " ORDER BY cs.schedule_date ASC, cs.start_time ASC";
        return Database::fetchAll($sql, $params);
    }

    public function getAllTenantSchedules(?string $startDate = null, ?string $endDate = null): array
    {
        $tid = TenantContext::getTenantId();
        $params = ['tid' => $tid];
        $sql = "SELECT cs.*, c.title as course_title, c.code as course_code, 
                       b.batch_name, u.first_name as faculty_first, u.last_name as faculty_last
                FROM class_schedules cs
                JOIN courses c ON cs.course_id = c.id
                LEFT JOIN batches b ON cs.batch_id = b.id
                JOIN users u ON cs.faculty_id = u.id
                WHERE cs.tenant_id = :tid";

        if ($startDate && $endDate) {
            $sql .= " AND cs.schedule_date BETWEEN :start AND :end";
            $params['start'] = $startDate;
            $params['end'] = $endDate;
        }

        $sql .= " ORDER BY cs.schedule_date ASC, cs.start_time ASC";
        return Database::fetchAll($sql, $params);
    }

    public function getUpcomingClassesForFaculty(int $facultyId, int $limit = 10): array
    {
        $tid = TenantContext::getTenantId();
        $today = date('Y-m-d');
        $sql = "SELECT cs.*, c.title as course_title, c.code as course_code, b.batch_name
                FROM class_schedules cs
                JOIN courses c ON cs.course_id = c.id
                LEFT JOIN batches b ON cs.batch_id = b.id
                WHERE cs.tenant_id = :tid AND cs.faculty_id = :fid 
                  AND (cs.status = 'live' OR (cs.status = 'scheduled' AND cs.schedule_date >= :today))
                ORDER BY (cs.status = 'live') DESC, cs.schedule_date ASC, cs.start_time ASC
                LIMIT {$limit}";
        
        return Database::fetchAll($sql, ['tid' => $tid, 'fid' => $facultyId, 'today' => $today]);
    }

    public function getStudentSchedules(int $studentId, int $batchId = 0): array
    {
        $tid = TenantContext::getTenantId();
        $today = date('Y-m-d');
        
        $sql = "SELECT DISTINCT cs.*, c.title as course_title, b.batch_name, u.first_name as faculty_first, u.last_name as faculty_last
                FROM class_schedules cs
                JOIN courses c ON cs.course_id = c.id
                LEFT JOIN batches b ON cs.batch_id = b.id
                JOIN users u ON cs.faculty_id = u.id
                JOIN course_enrollments ce ON ce.course_id = cs.course_id
                WHERE cs.tenant_id = :tid AND ce.user_id = :sid AND ce.status = 'active'
                  AND (cs.batch_id IS NULL OR cs.batch_id = 0 OR cs.batch_id = ce.batch_id OR cs.batch_id = :bid)
                  AND (cs.status = 'live' OR (cs.status = 'scheduled' AND cs.schedule_date >= :today))
                ORDER BY (cs.status = 'live') DESC, cs.schedule_date ASC, cs.start_time ASC";

        return Database::fetchAll($sql, ['tid' => $tid, 'sid' => $studentId, 'bid' => $batchId, 'today' => $today]);
    }

    public function getFacultyTelemetry(int $facultyId): array
    {
        $tid = TenantContext::getTenantId();
        
        // 1. Weekly Scheduled Count (Monday to Sunday of current week)
        $monday = date('Y-m-d', strtotime('monday this week'));
        $sunday = date('Y-m-d', strtotime('sunday this week'));
        
        $weeklySql = "SELECT COUNT(*) as cnt FROM class_schedules 
                      WHERE tenant_id = :tid AND faculty_id = :fid 
                        AND schedule_date BETWEEN :m AND :s AND status != 'cancelled'";
        $weeklyRow = Database::fetchOne($weeklySql, ['tid' => $tid, 'fid' => $facultyId, 'm' => $monday, 's' => $sunday]);
        $weeklyScheduled = (int)($weeklyRow['cnt'] ?? 0);

        // 2. Monthly Completed vs Total Scheduled
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');

        $monthlyTotalSql = "SELECT COUNT(*) as cnt FROM class_schedules 
                            WHERE tenant_id = :tid AND faculty_id = :fid 
                              AND schedule_date BETWEEN :som AND :eom AND status != 'cancelled'";
        $monthlyTotalRow = Database::fetchOne($monthlyTotalSql, ['tid' => $tid, 'fid' => $facultyId, 'som' => $startOfMonth, 'eom' => $endOfMonth]);
        $monthlyScheduled = (int)($monthlyTotalRow['cnt'] ?? 0);

        $monthlyDoneSql = "SELECT COUNT(*) as cnt FROM class_schedules 
                           WHERE tenant_id = :tid AND faculty_id = :fid 
                             AND schedule_date BETWEEN :som AND :eom AND status = 'completed'";
        $monthlyDoneRow = Database::fetchOne($monthlyDoneSql, ['tid' => $tid, 'fid' => $facultyId, 'som' => $startOfMonth, 'eom' => $endOfMonth]);
        $monthlyCompleted = (int)($monthlyDoneRow['cnt'] ?? 0);

        $monthlyCompletionPct = $monthlyScheduled > 0 ? (int)round(($monthlyCompleted / $monthlyScheduled) * 100) : 0;

        // 3. Assigned Batches & Courses Count
        $batchesSql = "SELECT COUNT(DISTINCT ci.course_id) as cnt 
                       FROM course_instructors ci 
                       WHERE ci.tenant_id = :tid AND ci.user_id = :fid";
        $batchesRow = Database::fetchOne($batchesSql, ['tid' => $tid, 'fid' => $facultyId]);
        $assignedBatches = (int)($batchesRow['cnt'] ?? 0);

        return [
            'weekly_scheduled' => $weeklyScheduled,
            'monthly_completed' => $monthlyCompleted,
            'monthly_scheduled' => $monthlyScheduled,
            'monthly_completion_pct' => $monthlyCompletionPct,
            'assigned_batches_count' => $assignedBatches
        ];
    }

    public function getUpcomingQuizzesForFaculty(int $facultyId, int $limit = 5): array
    {
        $tid = TenantContext::getTenantId();
        $sql = "SELECT q.*, c.title as course_title, c.code as course_code
                FROM quizzes q
                JOIN courses c ON q.course_id = c.id
                JOIN course_instructors ci ON ci.course_id = c.id
                WHERE q.tenant_id = :tid AND ci.user_id = :fid AND q.is_active = 1
                ORDER BY q.id DESC LIMIT {$limit}";

        return Database::fetchAll($sql, ['tid' => $tid, 'fid' => $facultyId]);
    }
}
