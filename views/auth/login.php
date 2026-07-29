<h4 class="text-center mb-1 text-light">Welcome Back</h4>
<p class="text-center text-muted small mb-4">Sign in to your Tyche Academy portal</p>

<form action="<?= Url::to('/login') ?>" method="POST">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required autofocus>
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label for="password" class="form-label">Password</label>
            <a href="<?= Url::to('/forgot-password') ?>" class="text-decoration-none small text-warning">Forgot?</a>
        </div>
        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn-tyche mt-3">Sign In to Platform</button>
</form>

<div class="mt-4 pt-3 border-top border-secondary text-center small text-muted">
    Trouble logging in? Contact academy support.
</div>
