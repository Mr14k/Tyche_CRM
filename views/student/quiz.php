<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Quiz: <?= Security::e($quiz['title']) ?></h2>
        <p class="text-secondary small m-0">Time Limit: <span class="text-warning font-monospace"><?= $quiz['time_limit_minutes'] ?> Mins</span> | Passing Score: <span class="text-success font-monospace"><?= $quiz['passing_score_percentage'] ?>%</span></p>
    </div>
    <div id="quizTimer" class="badge bg-danger p-2 font-monospace fs-6"><i class="bi bi-stopwatch"></i> <?= $quiz['time_limit_minutes'] ?>:00</div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <form action="<?= Url::to('/student/quizzes/' . $quiz['id']) ?>" method="POST" id="quizForm">
            <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

            <?php foreach ($quiz['questions'] as $qIdx => $q): ?>
                <div class="card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-warning text-dark font-monospace">Question <?= $qIdx + 1 ?> (<?= $q['marks'] ?> Marks)</span>
                        <span class="badge bg-secondary font-monospace"><?= strtoupper($q['question_type']) ?></span>
                    </div>
                    <h5 class="h6 text-light mb-3"><?= Security::e($q['question_text']) ?></h5>

                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($q['options'] as $opt): ?>
                            <div class="form-check p-2 rounded bg-dark border border-secondary">
                                <input class="form-check-input ms-1 me-2" type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $opt['id'] ?>" id="opt<?= $opt['id'] ?>">
                                <label class="form-check-label text-light small fw-semibold" for="opt<?= $opt['id'] ?>">
                                    <?= Security::e($opt['option_text']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-gold px-4 py-2 font-monospace mb-4"><i class="bi bi-send-check"></i> Submit Quiz Answers</button>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-clock-history"></i> My Previous Attempts</h5>
            <?php if (empty($attempts)): ?>
                <div class="text-muted small">No previous attempts recorded.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle m-0">
                        <thead>
                            <tr>
                                <th>Attempt</th>
                                <th>Score</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attempts as $att): ?>
                                <tr>
                                    <td class="font-monospace small">#<?= $att['attempt_number'] ?></td>
                                    <td class="font-monospace text-warning small"><?= $att['percentage'] ?>%</td>
                                    <td>
                                        <?php if ($att['is_passed']): ?>
                                            <span class="badge bg-success">PASSED</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">FAILED</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    let timeLeft = <?= (int)$quiz['time_limit_minutes'] * 60 ?>;
    const timerElem = document.getElementById('quizTimer');
    const quizForm = document.getElementById('quizForm');

    const countdown = setInterval(function() {
        if (timeLeft <= 0) {
            clearInterval(countdown);
            alert("Time expired! Auto-submitting quiz attempt now.");
            if (quizForm) quizForm.submit();
        } else {
            timeLeft--;
            const mins = Math.floor(timeLeft / 60);
            const secs = timeLeft % 60;
            timerElem.innerHTML = `<i class="bi bi-stopwatch"></i> ${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }
    }, 1000);
</script>
