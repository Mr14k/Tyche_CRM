<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\TenantContext;
use App\Models\ClassSchedule;
use App\Services\ClassScheduleService;
use App\Core\Database;

echo "Testing Faculty Dashboard Schedule Sync...\n";

TenantContext::setTenantId(3);
$service = new ClassScheduleService();
$model = new ClassSchedule();

// Create a new schedule for Guru Vinder (User #21)
$newScheduleId = $service->createSchedule([
    'course_id' => 5,
    'batch_id' => 5,
    'faculty_id' => 21,
    'title' => 'Advanced SEO & Analytics Masterclass',
    'schedule_date' => date('Y-m-d', strtotime('+1 day')),
    'start_time' => '11:00:00',
    'end_time' => '12:30:00',
    'meeting_provider' => 'jitsi'
], 18, 'admin');

// Verify schedule created
$upcoming = $model->getUpcomingClassesForFaculty(21);
$telemetry = $model->getFacultyTelemetry(21);
$instructorRow = Database::fetchOne("SELECT 1 FROM course_instructors WHERE tenant_id = 3 AND course_id = 5 AND user_id = 21");

echo "New Schedule ID: {$newScheduleId}\n";
echo "Weekly Scheduled Count: {$telemetry['weekly_scheduled']}\n";
echo "Upcoming Classes Count: " . count($upcoming) . "\n";

if ($newScheduleId > 0 && !empty($instructorRow) && $telemetry['weekly_scheduled'] > 0) {
    echo "[PASS] Faculty Dashboard schedule sync & auto-link verified!\n";
    exit(0);
} else {
    echo "[FAIL] Faculty Dashboard schedule sync failed!\n";
    exit(1);
}
