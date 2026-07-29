<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Case Studies & Student Stories</h2>
        <p class="text-secondary small m-0">Showcase campaign ROAS metrics and graduate career transformations</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-graph-up-arrow"></i> Client Case Studies</h5>
            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th>Client / Industry</th>
                            <th>Title</th>
                            <th>Results Metrics</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($caseStudies as $cs): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-light"><?= Security::e($cs['client_name']) ?></div>
                                    <div class="badge bg-secondary font-monospace"><?= Security::e($cs['industry']) ?></div>
                                </td>
                                <td class="small text-secondary"><?= Security::e($cs['title']) ?></td>
                                <td>
                                    <pre class="font-monospace text-warning small m-0" style="background:#0F1620; padding:4px 8px; border-radius:4px;"><?= Security::e($cs['results_summary']) ?></pre>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-plus-circle"></i> Create Case Study</h5>
            <form action="<?= Url::to('/admin/content/case-studies') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Client Name</label>
                    <input type="text" name="client_name" class="form-control" placeholder="e.g. Swiggy Growth Team" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Industry</label>
                    <input type="text" name="industry" class="form-control" placeholder="E-Commerce / Fintech" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Scaling ROAS from 1.8x to 4.2x" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Problem Statement</label>
                    <textarea name="problem_statement" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Solution & Strategy</label>
                    <textarea name="solution" class="form-control" rows="2" placeholder="Solution" required></textarea>
                    <textarea name="strategy" class="form-control mt-2" rows="2" placeholder="Strategy details" required></textarea>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label text-warning font-monospace small">Key ROAS Metric</label>
                        <input type="text" name="roas" class="form-control" placeholder="4.5x">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-warning font-monospace small">Leads / Growth</label>
                        <input type="text" name="leads" class="form-control" placeholder="10,000+">
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Create Case Study</button>
            </form>
        </div>
    </div>
</div>
