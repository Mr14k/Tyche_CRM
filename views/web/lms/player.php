<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($pageTitle) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg: #0A0E14;
            --sidebar-bg: #111722;
            --gold: #B98B3E;
            --gold-bright: #D9AE68;
            --parchment: #F3EEE2;
            --line: rgba(243,238,226,0.12);
        }
        body { background: var(--bg); color: var(--parchment); font-family: 'Inter', system-ui, sans-serif; height: 100vh; overflow: hidden; }
        .player-navbar { height: 60px; background: #161F2B; border-bottom: 1px solid var(--line); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; }
        .player-container { display: flex; height: calc(100vh - 60px); }
        .curriculum-sidebar { width: 340px; background: var(--sidebar-bg); border-right: 1px solid var(--line); overflow-y: auto; padding: 20px; }
        .video-canvas { flex: 1; padding: 24px; overflow-y: auto; }
        .notes-sidebar { width: 320px; background: var(--sidebar-bg); border-left: 1px solid var(--line); overflow-y: auto; padding: 20px; }
        .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; background: #000; border-radius: 8px; overflow: hidden; border: 1px solid var(--line); }
        .video-wrapper iframe { position: absolute; top:0; left:0; width:100%; height:100%; border:none; }
    </style>
</head>
<body>

<div class="player-navbar">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= Url::to('/courses/' . $course['slug']) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i> Exit Player</a>
        <span class="fw-bold text-light font-monospace">[<?= Security::e($course['code']) ?>] <?= Security::e($course['title']) ?></span>
    </div>
    <div class="d-flex align-items-center gap-4">
        <div class="d-flex align-items-center gap-2">
            <span class="small font-monospace text-muted">Course Progress:</span>
            <div class="progress" style="width: 120px; height: 8px; background: #0F1620;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $progressPct ?>%;"></div>
            </div>
            <span class="font-monospace text-warning small"><?= $progressPct ?>%</span>
        </div>
        <button id="markCompleteBtn" class="btn btn-gold btn-sm px-3 font-monospace">
            <i class="bi bi-check-circle-fill"></i> Mark Lesson Complete
        </button>
    </div>
</div>

<div class="player-container">
    <!-- Curriculum Sidebar -->
    <div class="curriculum-sidebar">
        <h6 class="font-monospace text-warning mb-3"><i class="bi bi-diagram-3"></i> Course Outline</h6>
        
        <?php foreach ($hierarchy as $mIdx => $mod): ?>
            <div class="fw-semibold text-light small mb-2 text-truncate"><i class="bi bi-folder text-warning"></i> Module <?= $mIdx + 1 ?>: <?= Security::e($mod['title']) ?></div>
            
            <?php foreach ($mod['chapters'] as $chap): ?>
                <div class="ps-2 mb-3 border-start border-secondary">
                    <div class="text-secondary small font-monospace mb-1" style="font-size:11px;"><?= Security::e($chap['title']) ?></div>
                    
                    <?php foreach ($chap['lessons'] as $les): ?>
                        <?php $isActive = ((int)$les['id'] === (int)$lesson['id']); ?>
                        <a href="<?= Url::to('/courses/' . $course['slug'] . '/learn/' . $les['id']) ?>" 
                           class="d-flex justify-content-between align-items-center p-2 rounded text-decoration-none mb-1 <?= $isActive ? 'bg-warning text-dark fw-bold' : 'text-light bg-dark bg-opacity-50' ?>" style="font-size:12px;">
                            <div class="text-truncate me-2">
                                <i class="bi bi-play-circle-fill me-1"></i> <?= Security::e($les['title']) ?>
                            </div>
                            <span class="font-monospace" style="font-size:10px;"><?= $les['duration_minutes'] ?>m</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>

    <!-- Main Video Canvas -->
    <div class="video-canvas">
        <div class="video-wrapper mb-4">
            <iframe src="<?= Security::e($signedVideoUrl) ?>" allowfullscreen></iframe>
        </div>

        <h2 class="h4 font-monospace text-light mb-2"><?= Security::e($lesson['title']) ?></h2>
        <div class="text-secondary small mb-4 font-monospace">Estimated duration: <?= $lesson['duration_minutes'] ?> minutes</div>

        <div class="card bg-dark border-secondary p-4">
            <h5 class="h6 font-monospace text-warning mb-2"><i class="bi bi-file-text"></i> Lesson Summary & Notes</h5>
            <p class="text-parchment small m-0"><?= nl2br(Security::e($lesson['summary_text'] ?? 'No summary provided for this video lesson.')) ?></p>
        </div>
    </div>

    <!-- Student Notes Sidebar -->
    <div class="notes-sidebar">
        <h6 class="font-monospace text-warning mb-3"><i class="bi bi-journal-text"></i> My Timestamped Notes</h6>
        
        <div class="mb-3">
            <textarea id="studentNoteInput" class="form-control font-monospace" rows="3" placeholder="Type lesson notes here..." style="background:#0A0E14; color:#F3EEE2; border-color:var(--line); font-size:12px;"></textarea>
            <button id="saveNoteBtn" class="btn btn-gold btn-sm w-100 mt-2 font-monospace"><i class="bi bi-plus"></i> Save Note</button>
        </div>

        <div id="notesList" class="d-flex flex-column gap-2" style="max-height: 400px; overflow-y: auto;">
            <?php foreach ($studentNotes as $nt): ?>
                <div class="p-2 rounded bg-dark border border-secondary small">
                    <div class="text-parchment"><?= Security::e($nt['note_text']) ?></div>
                    <div class="text-muted font-monospace mt-1" style="font-size:10px;"><?= Format::date($nt['created_at'], 'M d H:i') ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    const lessonId = <?= (int)$lesson['id'] ?>;
    const markCompleteBtn = document.getElementById('markCompleteBtn');
    const saveNoteBtn = document.getElementById('saveNoteBtn');
    const noteInput = document.getElementById('studentNoteInput');
    const notesList = document.getElementById('notesList');

    if (markCompleteBtn) {
        markCompleteBtn.addEventListener('click', function() {
            const formData = new FormData();
            formData.append('_token', '<?= Security::csrfToken() ?>');
            formData.append('lesson_id', lessonId);
            formData.append('watch_seconds', 900);
            formData.append('is_completed', 1);

            fetch('<?= Url::to('/courses/progress/update') ?>', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        markCompleteBtn.className = 'btn btn-success btn-sm px-3 font-monospace';
                        markCompleteBtn.innerText = '✓ Completed';
                    }
                });
        });
    }

    if (saveNoteBtn && noteInput) {
        saveNoteBtn.addEventListener('click', function() {
            const text = noteInput.value.trim();
            if (!text) return;

            const formData = new FormData();
            formData.append('_token', '<?= Security::csrfToken() ?>');
            formData.append('lesson_id', lessonId);
            formData.append('note_text', text);

            fetch('<?= Url::to('/courses/notes/save') ?>', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const noteDiv = document.createElement('div');
                        noteDiv.className = 'p-2 rounded bg-dark border border-secondary small';
                        noteDiv.innerHTML = `<div class="text-parchment">${text}</div><div class="text-muted font-monospace mt-1" style="font-size:10px;">Just now</div>`;
                        notesList.prepend(noteDiv);
                        noteInput.value = '';
                    }
                });
        });
    }
</script>

</body>
</html>
