<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Lms;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseModule;
use App\Models\CourseChapter;
use App\Models\CourseLesson;
use App\Helpers\Format;
use App\Helpers\Flash;
use App\Helpers\Url;
use App\Models\ActivityLog;

class CourseController extends Controller
{
    private Course $courseModel;
    private CourseCategory $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->courseModel = new Course();
        $this->categoryModel = new CourseCategory();
    }

    public function index(Request $request): void
    {
        $courses = $this->courseModel->all();
        $categories = $this->categoryModel->all();

        $this->view('admin.lms.courses.index', [
            'pageTitle' => 'LMS Course Management — Tyche Academy',
            'courses' => $courses,
            'categories' => $categories
        ], 'admin');
    }

    public function create(Request $request): void
    {
        $categories = $this->categoryModel->all();
        $this->view('admin.lms.courses.create', [
            'pageTitle' => 'Build New Academic Course — Tyche Academy',
            'categories' => $categories
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $user = Session::get('user');
        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'code' => 'required|unique:courses,code',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        $highlights = $this->buildHighlightsPayload($request);

        $courseId = $this->courseModel->create([
            'title' => $data['title'],
            'slug' => Format::slug($data['title']),
            'code' => strtoupper($data['code']),
            'category_id' => (int)$data['category_id'],
            'short_description' => $request->input('short_description'),
            'description' => $data['description'],
            'level' => $request->input('level', 'all_levels'),
            'language' => $request->input('language', 'English'),
            'duration_weeks' => (int)$request->input('duration_weeks', 8),
            'price' => (float)$data['price'],
            'live_cohort_price' => !empty($request->input('live_cohort_price')) ? (float)$request->input('live_cohort_price') : ((float)$data['price'] * 3),
            'discount_price' => !empty($request->input('discount_price')) ? (float)$request->input('discount_price') : null,
            'allow_skip_lessons' => $request->input('allow_skip_lessons') ? 1 : 0,
            'highlights_json' => !empty($highlights) ? json_encode($highlights) : null,
            'status' => $request->input('status', 'draft'),
            'created_by' => (int)$user['id']
        ]);

        (new ActivityLog())->record((int)$user['id'], 'LMS', 'CREATE_COURSE', "Created course {$data['title']} ({$data['code']})", $request->ip());
        Flash::success("Course '{$data['title']}' created. You can now build the academic module hierarchy.");
        $this->redirect(Url::to('/admin/lms/courses/' . $courseId . '/edit'));
    }

    public function edit(Request $request, string $id): void
    {
        $course = $this->courseModel->find((int)$id);
        if (!$course) {
            Flash::error('Course not found.');
            $this->redirect(Url::to('/admin/lms/courses'));
        }

        $categories = $this->categoryModel->all();
        $hierarchy = $this->courseModel->getFullHierarchy((int)$id);

        $this->view('admin.lms.courses.edit', [
            'pageTitle' => "Edit Course & Tier Fees: {$course['title']} — Tyche Academy",
            'course' => $course,
            'categories' => $categories,
            'hierarchy' => $hierarchy
        ], 'admin');
    }

    public function update(Request $request, string $id): void
    {
        $user = Session::get('user');
        $course = $this->courseModel->find((int)$id);
        if (!$course) {
            Flash::error('Course not found.');
            $this->redirect(Url::to('/admin/lms/courses'));
        }

        $data = $this->validate($request, [
            'title' => 'required|min:3',
            'code' => 'required',
            'price' => 'required|numeric'
        ]);

        $highlights = $this->buildHighlightsPayload($request);

        $this->courseModel->update((int)$id, [
            'title' => $data['title'],
            'code' => strtoupper($data['code']),
            'category_id' => (int)$request->input('category_id', $course['category_id']),
            'short_description' => $request->input('short_description'),
            'description' => $request->input('description', $course['description']),
            'level' => $request->input('level', 'all_levels'),
            'language' => $request->input('language', 'English'),
            'duration_weeks' => (int)$request->input('duration_weeks', 8),
            'price' => (float)$data['price'],
            'live_cohort_price' => !empty($request->input('live_cohort_price')) ? (float)$request->input('live_cohort_price') : null,
            'discount_price' => !empty($request->input('discount_price')) ? (float)$request->input('discount_price') : null,
            'allow_skip_lessons' => $request->input('allow_skip_lessons') ? 1 : 0,
            'highlights_json' => !empty($highlights) ? json_encode($highlights) : null,
            'status' => $request->input('status', 'draft')
        ]);

        (new ActivityLog())->record((int)$user['id'], 'LMS', 'UPDATE_COURSE', "Updated course details and custom highlights for {$data['title']}", $request->ip());
        Flash::success("Course details, tier fees, and comparison highlights for '{$data['title']}' updated successfully.");
        $this->redirect(Url::to('/admin/lms/courses/' . $id . '/edit'));
    }

    private function buildHighlightsPayload(Request $request): array
    {
        $secTitle = trim((string)$request->input('highlights_section_title', ''));
        $tradTitle = trim((string)$request->input('traditional_title', ''));
        $tradText = trim((string)$request->input('traditional_points', ''));
        $blueTitle = trim((string)$request->input('blueprint_title', ''));
        $blueText = trim((string)$request->input('blueprint_points', ''));

        if ($secTitle === '' && $tradText === '' && $blueText === '') {
            return [];
        }

        $tradPoints = array_values(array_filter(array_map('trim', explode("\n", $tradText))));
        $bluePoints = array_values(array_filter(array_map('trim', explode("\n", $blueText))));

        return [
            'section_title' => $secTitle !== '' ? $secTitle : 'Why Traditional Marketing Courses Fail in 2026',
            'traditional_title' => $tradTitle !== '' ? $tradTitle : 'Traditional Coaching Institutes',
            'traditional_points' => $tradPoints,
            'blueprint_title' => $blueTitle !== '' ? $blueTitle : 'The Tyche Executive Blueprint',
            'blueprint_points' => $bluePoints
        ];
    }

    public function storeModule(Request $request, string $courseId): void
    {
        $data = $this->validate($request, [
            'title' => 'required'
        ]);

        (new CourseModule())->create([
            'course_id' => (int)$courseId,
            'title' => $data['title'],
            'description' => $request->input('description'),
            'sort_order' => (int)$request->input('sort_order', 1)
        ]);

        Flash::success("Module added to course.");
        $this->redirect(Url::to('/admin/lms/courses/' . $courseId . '/edit'));
    }

    public function storeChapter(Request $request, string $courseId): void
    {
        $data = $this->validate($request, [
            'module_id' => 'required',
            'title' => 'required'
        ]);

        (new CourseChapter())->create([
            'module_id' => (int)$data['module_id'],
            'title' => $data['title'],
            'description' => $request->input('description'),
            'sort_order' => (int)$request->input('sort_order', 1)
        ]);

        Flash::success("Chapter added to module.");
        $this->redirect(Url::to('/admin/lms/courses/' . $courseId . '/edit'));
    }

    public function storeLesson(Request $request, string $courseId): void
    {
        $data = $this->validate($request, [
            'chapter_id' => 'required',
            'title' => 'required',
            'video_url' => 'required'
        ]);

        (new CourseLesson())->create([
            'chapter_id' => (int)$data['chapter_id'],
            'title' => $data['title'],
            'slug' => Format::slug($data['title']),
            'content_type' => $request->input('content_type', 'video'),
            'video_url' => $data['video_url'],
            'duration_minutes' => (int)$request->input('duration_minutes', 15),
            'summary_text' => $request->input('summary_text'),
            'is_preview' => $request->input('is_preview') ? 1 : 0,
            'sort_order' => (int)$request->input('sort_order', 1)
        ]);

        Flash::success("Lesson video added to chapter.");
        $this->redirect(Url::to('/admin/lms/courses/' . $courseId . '/edit'));
    }
}
