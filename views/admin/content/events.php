<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Workshops & Live Webinars Manager</h2>
        <p class="text-secondary small m-0">Schedule free workshops, masterclasses, and countdown registration events</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-calendar-event"></i> Event Schedule</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $ev): ?>
                            <tr>
                                <td class="fw-semibold text-light"><?= Security::e($ev['title']) ?></td>
                                <td><span class="badge bg-info font-monospace"><?= Security::e($ev['type']) ?></span></td>
                                <td class="small font-monospace text-warning"><?= Format::date($ev['event_date'], 'M d, Y h:i A') ?></td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Schedule New Event</h5>
            <form action="<?= Url::to('/admin/content/events') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Event Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Masterclass: AI Overviews in SEO" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Event Type</label>
                    <select name="type" class="form-select" style="background:#0F1620; color:#F3EEE2; border-color:rgba(243,238,226,0.14);">
                        <option value="webinar">Live Webinar</option>
                        <option value="workshop">Interactive Workshop</option>
                        <option value="masterclass">Executive Masterclass</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Event Date & Time</label>
                    <input type="datetime-local" name="event_date" class="form-control" required style="background:#0F1620; color:#F3EEE2;">
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Event Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Schedule Webinar Event</button>
            </form>
        </div>
    </div>
</div>
