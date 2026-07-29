<h4 class="text-center mb-1 text-light">Set New Password</h4>
<p class="text-center text-muted small mb-4">Choose a strong password for <?= Security::e($email) ?></p>

<form action="<?= Url::to('/reset-password') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    <input type="hidden" name="token" value="<?= Security::e($token) ?>">
    <input type="hidden" name="email" value="<?= Security::e($email) ?>">

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="At least 8 characters" required autofocus>
    </div>

    <div class="mb-3">
        <label for="password_confirm" class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Repeat new password" required>
    </div>

    <button type="submit" class="btn-tyche mt-3">Update Password</button>
</form>

<div class="mt-4 pt-3 border-top border-secondary text-center auth-links">
    <a href="<?= Url::to('/login') ?>"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
</div>
