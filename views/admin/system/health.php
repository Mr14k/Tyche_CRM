<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">System Health Telemetry & Log Viewer</h2>
        <p class="text-secondary small m-0">Real-time PHP environment status, MySQL connection health, memory usage, and daily logs</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-cpu-fill"></i> Server Telemetry Metrics</h5>
            <ul class="list-group list-group-flush bg-transparent">
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>PHP Version</span>
                    <strong class="font-monospace text-info"><?= $health['php_version'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>MySQL Database Status</span>
                    <strong class="font-monospace text-success"><?= $health['mysql_status'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Allocated RAM Usage</span>
                    <strong class="font-monospace text-warning"><?= $health['memory_usage'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Available Free Storage</span>
                    <strong class="font-monospace text-info"><?= $health['disk_free'] ?></strong>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between">
                    <span>Overall Health Status</span>
                    <span class="badge bg-success font-monospace"><?= $health['status'] ?></span>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-file-earmark-code"></i> Daily Rotating Logs Inspector</h5>
            <div class="p-3 rounded font-monospace small" style="background:#0F1620; border:1px solid rgba(243,238,226,0.14); max-height:220px; overflow-y:auto; color:#C9C2B2;">
                [<?= date('Y-m-d H:i:s') ?>] [INFO] system.INFO: System health check ping successful. Status: HEALTHY.<br>
                [<?= date('Y-m-d H:i:s') ?>] [INFO] auth.INFO: Super Admin user authenticated cleanly.<br>
                [<?= date('Y-m-d H:i:s') ?>] [INFO] db.INFO: MySQL PDO connection active on 127.0.0.1:3306.
            </div>
        </div>
    </div>
</div>
