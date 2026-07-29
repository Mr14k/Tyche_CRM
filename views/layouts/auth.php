<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($pageTitle ?? 'Authentication — Tyche Academy') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg: #0F1620;
            --bg-elevated: #161F2B;
            --gold: #B98B3E;
            --gold-bright: #D9AE68;
            --parchment: #F3EEE2;
            --parchment-dim: #C9C2B2;
            --line: rgba(243,238,226,0.14);
        }
        body {
            background-color: var(--bg);
            color: var(--parchment);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: var(--bg-elevated);
            border: 1px solid var(--line);
            border-radius: 8px;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }
        .brand-mark {
            font-family: 'Fraunces', serif;
            font-size: 24px;
            color: var(--parchment);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .form-control {
            background: rgba(15,22,32,0.8);
            border: 1px solid var(--line);
            color: var(--parchment);
            padding: 12px 16px;
        }
        .form-control:focus {
            background: #0F1620;
            border-color: var(--gold);
            color: var(--parchment);
            box-shadow: 0 0 0 0.25rem rgba(185,139,62,0.25);
        }
        .form-label {
            font-size: 13px;
            color: var(--parchment-dim);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .btn-tyche {
            background: var(--gold);
            color: var(--bg);
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-tyche:hover {
            background: var(--gold-bright);
            color: var(--bg);
        }
        .auth-links a {
            color: var(--gold-bright);
            text-decoration: none;
            font-size: 13px;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="text-center mb-4">
            <a href="<?= Url::to('/') ?>" class="brand-mark">
                <svg width="32" height="32" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="18" stroke="#B98B3E" stroke-width="1.4"/>
                    <circle cx="20" cy="20" r="3" fill="#B98B3E"/>
                    <path d="M20 4V13M20 27V36M4 20H13M27 20H36" stroke="#B98B3E" stroke-width="1.2"/>
                </svg>
                Tyche Academy
            </a>
        </div>
        <?= \App\Helpers\Flash::render() ?>
        <?= $content ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
