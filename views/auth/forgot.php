<h4 class="text-center mb-1 text-light">Reset Password</h4>
<p class="text-center text-muted small mb-4">Enter your email to receive a recovery link</p>

<form action="<?= Url::to('/forgot-password') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required autofocus>
    </div>

    <button type="submit" class="btn-tyche mt-3">Send Reset Link</button>
</form>

<div class="mt-4 pt-3 border-top border-secondary text-center auth-links">
    <a href="<?= Url::to('/login') ?>"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
</div>
