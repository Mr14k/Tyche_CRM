<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Access Denied — Tyche Academy</title>
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
        <h1 class="display-1 gold fw-bold">403</h1>
        <h2>Access Restricted</h2>
        <p class="text-secondary mt-3">You do not have the required permissions or role to access this resource.</p>
        <a href="<?= \App\Helpers\Url::to('/dashboard') ?>" class="btn-tyche">Back to Dashboard</a>
    </div>
</body>
</html>
