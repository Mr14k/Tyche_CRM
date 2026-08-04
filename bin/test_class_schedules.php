<?php

declare(strict_types=1);

$root = dirname(__DIR__);
spl_autoload_register(function ($class) use ($root) {
    $file = $root . '/app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});
\App\Core\EnvLoader::load($root . '/.env');

use App\Core\Database;
use App\Core\TenantContext;
use App\Models\ClassSchedule;
use App\Services\ClassScheduleService;

echo "=====================================================================\n";
echo "   CLASS SCHEDULING & DIGITAL CLASSROOM MODULE TEST SUITE            \n";
echo "=====================================================================\n\n";

$passed = 0;
$failed = 0;

TenantContext::setTenantId(1);

function testAssert(bool $cond, string $msg, &$passed, &$failed): void {
    if ($cond) {
        echo "[PASS] {$msg}\n";
        $passed++;
    } else {
        echo "[FAIL] {$msg}\n";
        $failed++;
    }
}

// 1. Verify class_schedules table exists
$tables = array_column(Database::fetchAll("SHOW TABLES"), key(Database::fetchAll("SHOW TABLES")[0]));
testAssert(in_array('class_schedules', $tables, true), "Database contains 'class_schedules' table", $passed, $failed);

// 2. Test ClassScheduleService createSchedule
$service = new ClassScheduleService();
$model = new ClassSchedule();

// Ensure course_instructors record exists for testing
Database::execute(
    "INSERT IGNORE INTO course_instructors (course_id, user_id, role, tenant_id) VALUES (1, 2, 'instructor', 1)"
);

try {
    $scheduleId = $service->createSchedule([
        'course_id' => 1,
        'batch_id' => null,
        'faculty_id' => 2,
        'title' => 'Test Lecture: Advanced PHP & Architecture',
        'description' => 'Covering MVC and SOLID principles',
        'schedule_date' => date('Y-m-d'),
        'start_time' => '10:00:00',
        'end_time' => '11:30:00',
        'meeting_provider' => 'jitsi'
    ], 2, 'faculty');

    testAssert($scheduleId > 0, "Faculty created class schedule #{$scheduleId}", $passed, $failed);

    $schedule = $model->find($scheduleId);
    testAssert($schedule !== null && str_contains($schedule['meeting_link'], 'https://meet.jit.si/Tyche_Class_'), "Auto-generated Jitsi Digital Classroom URL: {$schedule['meeting_link']}", $passed, $failed);

    // 3. Test Toggle Go Live
    $liveRes = $service->toggleGoLive($scheduleId, 2);
    testAssert($liveRes['status'] === 'live', "Toggled class status to LIVE NOW", $passed, $failed);

    $liveSchedule = $model->find($scheduleId);
    testAssert($liveSchedule['status'] === 'live', "Verified database status is 'live'", $passed, $failed);

    // 4. Test Toggle End Class
    $endRes = $service->toggleGoLive($scheduleId, 2);
    testAssert($endRes['status'] === 'completed', "Toggled class status to COMPLETED", $passed, $failed);

    // 5. Test Faculty Telemetry
    $telemetry = $model->getFacultyTelemetry(2);
    testAssert(isset($telemetry['weekly_scheduled']) && isset($telemetry['monthly_completion_pct']), "Computed Faculty Telemetry: Weekly Scheduled={$telemetry['weekly_scheduled']}, Monthly Completion={$telemetry['monthly_completion_pct']}%", $passed, $failed);

} catch (\Throwable $e) {
    testAssert(false, "Exception occurred: " . $e->getMessage(), $passed, $failed);
}

echo "\n-----------------------------------------------------\n";
echo "CLASS SCHEDULING TEST SUMMARY: Passed: {$passed} | Failed: {$failed}\n";
echo "=====================================================\n";

exit($failed > 0 ? 1 : 0);
