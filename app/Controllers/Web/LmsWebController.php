<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseEnrollment;
use App\Models\LessonProgress;
use App\Models\LessonNote;
use App\Models\Payment;
use App\Services\LessonProgressService;
use App\Services\AuthService;
use App\Services\InvoiceService;
use App\Services\NotificationService;
use App\Services\MarketingAutomationService;
use App\Exceptions\NotFoundException;
use App\Exceptions\AccessDeniedException;
use App\Helpers\Flash;
use App\Helpers\Url;

class LmsWebController extends Controller
{
    private Course $courseModel;
    private CourseLesson $lessonModel;
    private CourseEnrollment $enrollmentModel;
    private LessonProgressService $progressService;

    public function __construct()
    {
        parent::__construct();
        $this->courseModel = new Course();
        $this->lessonModel = new CourseLesson();
        $this->enrollmentModel = new CourseEnrollment();
        $this->progressService = new LessonProgressService();
    }

    public function catalog(Request $request): void
    {
        $courses = $this->courseModel->getPublishedCatalog();
        $this->view('web.lms.catalog', [
            'pageTitle' => 'Course Catalog & Curriculum — Tyche Academy',
            'courses' => $courses
        ], 'web');
    }

    public function showCourse(Request $request, string $slug): void
    {
        $course = $this->courseModel->findBySlug($slug);
        if (!$course || $course['status'] !== 'published') {
            throw new NotFoundException("Course not found.");
        }

        $hierarchy = $this->courseModel->getFullHierarchy((int)$course['id']);
        $user = Session::get('user');
        $isEnrolled = $user ? $this->enrollmentModel->isEnrolled((int)$user['id'], (int)$course['id']) : false;

        $this->view('web.lms.course', [
            'pageTitle' => $course['title'] . ' — Tyche Academy',
            'course' => $course,
            'hierarchy' => $hierarchy,
            'isEnrolled' => $isEnrolled
        ], 'web');
    }

    public function checkoutPage(Request $request, string $slug): void
    {
        $course = $this->courseModel->findBySlug($slug);
        if (!$course || $course['status'] !== 'published') {
            throw new NotFoundException("Course not found.");
        }

        $tier = $request->input('tier', 'self_paced') === 'live_cohort' ? 'live_cohort' : 'self_paced';
        $basePrice = $tier === 'live_cohort' ? (float)($course['live_cohort_price'] ?? ($course['price'] * 3)) : (float)$course['price'];

        $user = Session::get('user');

        $this->view('web.lms.checkout', [
            'pageTitle' => "Checkout & Enrollment: {$course['title']} — Tyche Academy",
            'course' => $course,
            'tier' => $tier,
            'basePrice' => $basePrice,
            'user' => $user
        ], 'web');
    }

    public function registerAndBuy(Request $request, string $slug): void
    {
        $course = $this->courseModel->findBySlug($slug);
        if (!$course) {
            throw new NotFoundException("Course not found.");
        }

        $data = $this->validate($request, [
            'first_name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $auth = new AuthService();
        $user = $auth->registerStudent($data, $request->ip(), $request->userAgent());

        $this->executeEnrollmentAndPayment($request, $course, (int)$user['id']);
    }

    public function processBuy(Request $request, string $slug): void
    {
        $user = Session::get('user');
        if (!$user) {
            $this->redirect(Url::to('/courses/' . $slug . '/checkout'));
            return;
        }

        $course = $this->courseModel->findBySlug($slug);
        if (!$course) {
            throw new NotFoundException("Course not found.");
        }

        $this->executeEnrollmentAndPayment($request, $course, (int)$user['id']);
    }

    private function executeEnrollmentAndPayment(Request $request, array $course, int $userId): void
    {
        $tier = $request->input('tier', 'self_paced') === 'live_cohort' ? 'live_cohort' : 'self_paced';
        $basePrice = $tier === 'live_cohort' ? (float)($course['live_cohort_price'] ?? ($course['price'] * 3)) : (float)$course['price'];
        $couponCode = trim((string)$request->input('coupon_code', ''));
        $paymentMethod = $request->input('payment_method', 'online_gateway');

        $finalAmount = $basePrice;
        if ($couponCode !== '') {
            $automationService = new MarketingAutomationService();
            $res = $automationService->validateCoupon($couponCode, $basePrice);
            if (!empty($res['valid'])) {
                $finalAmount = (float)$res['discounted_total'];
            }
        }

        // Check if already enrolled
        if (!$this->enrollmentModel->isEnrolled($userId, (int)$course['id'])) {
            $this->enrollmentModel->create([
                'user_id' => $userId,
                'course_id' => (int)$course['id'],
                'status' => 'active'
            ]);
        }

        // Record Payment in DB
        $paymentModel = new Payment();
        $paymentId = (int)$paymentModel->create([
            'payment_reference' => 'PAY_' . strtoupper(substr(md5((string)uniqid()), 0, 10)),
            'user_id' => $userId,
            'course_id' => (int)$course['id'],
            'admission_id' => null,
            'amount' => $finalAmount,
            'gateway' => ($paymentMethod === 'offline') ? 'bank_transfer' : 'upi',
            'transaction_id' => 'TXN_' . strtoupper(substr(md5((string)uniqid()), 0, 10)),
            'status' => 'completed',
            'payment_date' => date('Y-m-d H:i:s')
        ]);

        // Generate 18% GST Invoice
        (new InvoiceService())->generateGstInvoice($paymentId, $userId, $finalAmount);


        // Dispatch Confirmation Notification
        (new NotificationService())->dispatch(
            $userId,
            'student',
            'Course Enrollment & GST Receipt Confirmed!',
            "You have successfully enrolled in {$course['title']}. Happy Learning!",
            '/courses/' . $course['slug']
        );

        // Find first lesson for immediate redirection into classroom player
        $hierarchy = $this->courseModel->getFullHierarchy((int)$course['id']);
        $firstLessonId = $hierarchy[0]['chapters'][0]['lessons'][0]['id'] ?? null;

        Flash::success("Payment Successful! Welcome to your digital classroom for {$course['title']}.");

        if ($firstLessonId) {
            $this->redirect(Url::to('/courses/' . $course['slug'] . '/learn/' . $firstLessonId));
        } else {
            $this->redirect(Url::to('/student/dashboard'));
        }
    }

    public function player(Request $request, string $slug, string $lessonId): void
    {
        $user = Session::get('user');
        if (!$user) {
            $this->redirect(Url::to('/login'));
        }

        $course = $this->courseModel->findBySlug($slug);
        if (!$course) {
            throw new NotFoundException("Course not found.");
        }

        $lesson = $this->lessonModel->findWithDetails((int)$lessonId);
        if (!$lesson) {
            throw new NotFoundException("Lesson not found.");
        }

        // Sequential Lesson Locking & Enrollment Validation
        if (!$this->progressService->isLessonUnlocked((int)$user['id'], (int)$lessonId)) {
            throw new AccessDeniedException("Sequential Lesson Locked: You must complete the preceding lesson before accessing this lesson.");
        }

        // Get Signed Video Stream URL
        $signedVideoUrl = $this->progressService->getSignedVideoUrl((int)$user['id'], (int)$lessonId);

        $hierarchy = $this->courseModel->getFullHierarchy((int)$course['id']);
        $progressModel = new LessonProgress();
        $progressPct = $progressModel->getCourseProgressPercentage((int)$user['id'], (int)$course['id']);
        $studentNotes = (new LessonNote())->getForStudentLesson((int)$user['id'], (int)$lessonId);

        $this->view('web.lms.player', [
            'pageTitle' => "Learning: {$lesson['title']} — Tyche Academy",
            'course' => $course,
            'lesson' => $lesson,
            'signedVideoUrl' => $signedVideoUrl,
            'hierarchy' => $hierarchy,
            'progressPct' => $progressPct,
            'studentNotes' => $studentNotes
        ], 'none'); // Full-screen player layout
    }

    public function updateProgress(Request $request): void
    {
        $user = Session::get('user');
        if (!$user) {
            $this->json(['error' => 'Unauthenticated'], 401);
        }

        $lessonId = (int)$request->input('lesson_id');
        $watchSeconds = (int)$request->input('watch_seconds', 0);
        $isCompleted = (bool)$request->input('is_completed', false);

        (new LessonProgress())->recordProgress((int)$user['id'], $lessonId, $watchSeconds, $isCompleted);
        $this->json(['success' => true]);
    }

    public function saveNote(Request $request): void
    {
        $user = Session::get('user');
        if (!$user) {
            $this->json(['error' => 'Unauthenticated'], 401);
        }

        $lessonId = (int)$request->input('lesson_id');
        $noteText = trim((string)$request->input('note_text', ''));
        $timestamp = (int)$request->input('timestamp_seconds', 0);

        if ($noteText !== '') {
            (new LessonNote())->create([
                'user_id' => (int)$user['id'],
                'lesson_id' => $lessonId,
                'note_text' => $noteText,
                'timestamp_seconds' => $timestamp
            ]);
        }

        $this->json(['success' => true]);
    }
}
