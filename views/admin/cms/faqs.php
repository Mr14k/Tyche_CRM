<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">FAQ Management Center</h2>
        <p class="text-secondary small m-0">Manage website FAQs and inquiry response items</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-question-circle"></i> Active FAQs</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($faqs as $faq): ?>
                            <tr>
                                <td><span class="badge bg-secondary font-monospace"><?= Security::e($faq['category']) ?></span></td>
                                <td class="fw-semibold text-light small"><?= Security::e($faq['question']) ?></td>
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
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Add FAQ Item</h5>
            <form action="<?= Url::to('/admin/cms/faqs') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Category</label>
                    <input type="text" name="category" class="form-control" value="General" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Question</label>
                    <input type="text" name="question" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Detailed Answer</label>
                    <textarea name="answer" class="form-control" rows="4" required></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Add FAQ Item</button>
            </form>
        </div>
    </div>
</div>
