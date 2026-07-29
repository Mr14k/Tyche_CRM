<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found — Tyche Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #0F1620; color: #F3EEE2; font-family: system-ui, sans-serif; display: flex; align-items: center; min-height: 100vh; justify-content: center; text-align: center; }
        .error-card { max-width: 500px; padding: 40px; border: 1px solid rgba(243,238,226,0.14); background: #161F2B; border-radius: 8px; }
        .gold { color: #D9AE68; }
        .btn-tyche { background: #B98B3E; color: #0F1620; font-weight: 600; text-transform: uppercase; text-decoration: none; padding: 10px 24px; border-radius: 4px; display: inline-block; margin-top: 20px; }
        .btn-tyche:hover { background: #D9AE68; color: #0F1620; }
    </style>
</head>
<body>
    <div class="error-card">
        <h1 class="display-1 gold fw-bold">404</h1>
        <h2>Page Not Found</h2>
        <p class="text-secondary mt-3">The page or resource you requested could not be located on the Tyche Academy platform.</p>
        <?php if (isset($isDebug) && $isDebug && isset($exception)): ?>
            <div class="alert alert-warning text-start mt-3 small text-dark">
                <strong>Debug Info:</strong> <?= htmlspecialchars($exception->getMessage()) ?>
            </div>
        <?php endif; ?>
        <a href="<?= \App\Helpers\Url::to('/') ?>" class="btn-tyche">Return Home</a>
    </div>
</body>
</html>
