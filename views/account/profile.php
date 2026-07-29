<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">My Account Profile & Settings</h2>
        <p class="text-secondary small m-0">Manage personal details, avatar, and security credentials</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom p-4 text-center">
            <div class="mb-3 d-flex justify-content-center">
                <?php if ($user['avatar']): ?>
                    <img src="<?= Url::upload($user['avatar']) ?>" class="rounded-circle border border-warning shadow" style="width:120px; height:120px; object-fit:cover;">
                <?php else: ?>
                    <div class="rounded-circle bg-secondary text-light d-flex align-items-center justify-content-center fw-bold border border-warning shadow mx-auto" style="width:120px; height:120px; font-size:36px;">
                        <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>
            <h5 class="fw-bold text-light m-0"><?= Security::e($user['first_name'] . ' ' . $user['last_name']) ?></h5>
            <div class="text-warning small font-monospace mt-1"><?= Security::e($user['email']) ?></div>

            <form action="<?= Url::to('/account/avatar') ?>" method="POST" enctype="multipart/form-data" class="mt-4">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                <div class="mb-2">
                    <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-outline-warning btn-sm w-100"><i class="bi bi-upload"></i> Upload New Avatar</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom p-4 mb-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-person"></i> Personal Profile Details</h5>
            <form action="<?= Url::to('/account/profile') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= Security::e($user['first_name']) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= Security::e($user['last_name']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">Email Address (Read-Only)</label>
                    <input type="email" class="form-control" value="<?= Security::e($user['email']) ?>" readonly disabled style="opacity:0.6;">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="<?= Security::e($user['phone'] ?? '') ?>" required>
                </div>

                <button type="submit" class="btn btn-gold btn-sm px-4">Update Details</button>
            </form>
        </div>

        <div class="card-custom p-4">
            <h5 class="h6 font-monospace text-warning mb-3"><i class="bi bi-key"></i> Security & Password Credentials</h5>
            <form action="<?= Url::to('/account/password') ?>" method="POST">
                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

                <div class="mb-3">
                    <label class="form-label text-muted small">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small">New Password</label>
                        <input type="password" name="new_password" class="form-control" required minlength="8">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small">Confirm New Password</label>
                        <input type="password" name="new_password_confirm" class="form-control" required minlength="8">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-warning btn-sm px-4">Change Password</button>
            </form>
        </div>
    </div>
</div>
