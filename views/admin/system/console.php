<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">System Administration Console</h2>
        <p class="text-secondary small m-0">Centralized platform controls, cache management, and maintenance mode</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-arrow-repeat"></i> Cache Clearing Tools</h5>
            <p class="text-secondary small">Purge compiled views, router definitions, OPCache, and session caches across the monolithic framework.</p>
            <form action="<?= Url::to('/admin/system/cache/clear') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <button type="submit" class="btn btn-warning btn-sm fw-bold px-4"><i class="bi bi-trash-fill me-1"></i> Flush Application Cache</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-shield-check"></i> OWASP Security Header Telemetry</h5>
            <ul class="list-group list-group-flush bg-transparent">
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>X-Frame-Options</span>
                    <span class="badge bg-success font-monospace">SAMEORIGIN</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>X-Content-Type-Options</span>
                    <span class="badge bg-success font-monospace">nosniff</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Content Security Policy (CSP)</span>
                    <span class="badge bg-success font-monospace">Active</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Strict-Transport-Security (HSTS)</span>
                    <span class="badge bg-success font-monospace">Enabled</span>
                </li>
            </ul>
        </div>
    </div>
</div>
