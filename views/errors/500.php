<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 System Error — Tyche Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #0F1620; color: #F3EEE2; font-family: system-ui, sans-serif; display: flex; align-items: center; min-height: 100vh; justify-content: center; text-align: center; }
        .error-card { max-width: 600px; padding: 40px; border: 1px solid rgba(243,238,226,0.14); background: #161F2B; border-radius: 8px; }
        .gold { color: #D9AE68; }
        .btn-tyche { background: #B98B3E; color: #0F1620; font-weight: 600; text-transform: uppercase; text-decoration: none; padding: 10px 24px; border-radius: 4px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="error-card text-start">
        <h1 class="display-1 gold fw-bold text-center">500</h1>
        <h2 class="text-center">Internal Server Error</h2>
        <p class="text-secondary text-center mt-3">An unhandled system exception occurred. The incident has been logged.</p>
        <?php if (isset($isDebug) && $isDebug && isset($exception)): ?>
            <div class="alert alert-danger text-start mt-3 small">
                <strong>Exception:</strong> <?= htmlspecialchars($exception->getMessage()) ?><br>
                <strong>File:</strong> <?= htmlspecialchars($exception->getFile()) ?> (Line <?= $exception->getLine() ?>)
                <pre class="mt-2 text-dark bg-light p-2 rounded" style="max-height:200px; overflow:auto;"><?= htmlspecialchars($exception->getTraceAsString()) ?></pre>
            </div>
        <?php endif; ?>
        <div class="text-center">
            <a href="<?= \App\Helpers\Url::to('/') ?>" class="btn-tyche">Return to Safety</a>
        </div>
    </div>
</body>
</html>
