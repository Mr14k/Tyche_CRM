<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Content;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Event;
use App\Helpers\Format;
use App\Helpers\Flash;
use App\Helpers\Url;

class EventController extends Controller
{
    private Event $eventModel;

    public function __construct()
    {
        parent::__construct();
        $this->eventModel = new Event();
    }

    public function index(Request $request): void
    {
        $events = $this->eventModel->all();
        $this->view('admin.content.events', [
            'pageTitle' => 'Workshops & Webinars Manager — Tyche Academy',
            'events' => $events
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'event_date' => 'required',
            'description' => 'required'
        ]);

        $this->eventModel->create([
            'title' => $data['title'],
            'slug' => Format::slug($data['title']),
            'type' => $data['type'],
            'description' => $data['description'],
            'event_date' => $data['event_date'],
            'duration_minutes' => (int)$request->input('duration_minutes', 90),
            'meeting_link' => $request->input('meeting_link'),
            'is_active' => 1
        ]);

        Flash::success("Event created successfully.");
        $this->redirect(Url::to('/admin/content/events'));
    }
}
