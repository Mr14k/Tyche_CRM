<?php
// Uses layouts/web.php
$subtotal = round($basePrice / 1.18, 2);
$gstAmount = round($basePrice - $subtotal, 2);
?>

<div class="hero-light py-4 border-bottom border-slate-200">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb font-monospace small m-0">
                <li class="breadcrumb-item"><a href="<?= Url::to('/courses/' . $course['slug']) ?>" class="text-primary text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to <?= Security::e($course['title']) ?></a></li>
                <li class="breadcrumb-item text-slate-500 active">Secure Checkout & Direct Enrollment</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Order Summary & GST Breakdown Card -->
        <div class="col-lg-5">
            <div class="card-edtech p-4 p-md-5 bg-white border-primary shadow-sm">
                <span class="badge bg-primary text-white font-monospace px-3 py-2 rounded-pill mb-3"><?= strtoupper(str_replace('_', ' ', $tier)) ?></span>
                <h3 class="h4 font-heading fw-bold text-slate-900 mb-2"><?= Security::e($course['title']) ?></h3>
                <p class="text-slate-600 small mb-4"><?= Security::e($course['short_description'] ?? '') ?></p>

                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 mb-4 font-monospace small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">Base Tuition Fee:</span>
                        <span class="text-slate-900 fw-bold">₹ <?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">GST (18% Statutory Tax):</span>
                        <span class="text-slate-900">₹ <?= number_format($gstAmount, 2) ?></span>
                    </div>
                    <hr class="my-2 border-slate-200">
                    <div class="d-flex justify-content-between fs-6 fw-bold">
                        <span class="text-slate-900">Total Total Amount:</span>
                        <span class="text-primary fs-5">₹ <?= number_format($basePrice, 2) ?></span>
                    </div>
                </div>

                <!-- Features Included -->
                <h6 class="font-heading fw-bold text-slate-900 small text-uppercase tracking-wider mb-2">Instant Enrollment Benefits:</h6>
                <ul class="list-unstyled space-y-2 text-slate-700 small mb-4">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Instant HD Video Classroom Player Access</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Downloadable Capstone Resources & Materials</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Automated 18% GST Tax Invoice PDF</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> SHA-256 Cryptographic Certificate Hash</li>
                </ul>

                <div class="p-3 bg-primary-light rounded-3 text-center border border-primary">
                    <span class="small text-primary fw-bold font-monospace"><i class="bi bi-shield-lock-fill me-1"></i> 256-Bit SSL Encrypted Payment Protection</span>
                </div>
            </div>
        </div>

        <!-- Student Account & Payment Flow -->
        <div class="col-lg-7">
            <?php if ($user): ?>
                <!-- Authenticated Direct Payment Form -->
                <div class="card-edtech p-4 p-md-5 bg-white border-slate-200 shadow-lg">
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-slate-50 rounded-3 border border-slate-200">
                        <div class="bg-primary text-white rounded-circle fw-bold p-2 d-flex align-items-center justify-content-center" style="width:42px; height:42px;">
                            <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-bold text-slate-900 small">Enrolling as <?= Security::e($user['first_name'] . ' ' . $user['last_name']) ?></div>
                            <div class="text-slate-500 small font-monospace"><?= Security::e($user['email']) ?></div>
                        </div>
                    </div>

                    <form action="<?= Url::to('/courses/' . $course['slug'] . '/process-buy') ?>" method="POST" class="space-y-4">
                        <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                        <input type="hidden" name="tier" value="<?= Security::e($tier) ?>">

                        <!-- Coupon Code Discount Field -->
                        <div class="mb-4">
                            <label class="form-label text-slate-800 fw-semibold small">Discount Coupon Code (Optional)</label>
                            <div class="input-group">
                                <input type="text" name="coupon_code" class="form-control font-monospace" placeholder="e.g. TYCHE2026 (15% OFF)">
                                <span class="input-group-text bg-slate-100 font-monospace text-slate-600 small">Apply Coupon</span>
                            </div>
                        </div>

                        <!-- Payment Method Selector -->
                        <div class="mb-4">
                            <label class="form-label text-slate-800 fw-semibold small">Select Payment Method</label>
                            <div class="space-y-2">
                                <div class="form-check p-3 border rounded-3 bg-slate-50 d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="payOnline" value="online_gateway" checked>
                                        <label class="form-check-label fw-semibold text-slate-900" for="payOnline">
                                            Online Instant Gateway (UPI, Credit/Debit Card, Netbanking)
                                        </label>
                                    </div>
                                    <i class="bi bi-credit-card-2-front-fill text-primary fs-4"></i>
                                </div>
                                <div class="form-check p-3 border rounded-3 bg-slate-50 d-flex align-items-center justify-content-between">
                                    <div>
                                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="payOffline" value="offline">
                                        <label class="form-check-label fw-semibold text-slate-900" for="payOffline">
                                            Offline Direct Bank Transfer / 2-Installment Schedule
                                        </label>
                                    </div>
                                    <i class="bi bi-bank2 text-secondary fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                            Complete Payment & Launch Classroom <i class="bi bi-play-circle-fill ms-2"></i>
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <!-- Unauthenticated: Dual Tab Sign-Up & Direct Buy Form -->
                <div class="card-edtech p-4 p-md-5 bg-white border-slate-200 shadow-lg">
                    <h3 class="h4 font-heading fw-bold text-slate-900 mb-2">Create Account & Complete Enrollment</h3>
                    <p class="text-slate-600 small mb-4">Set up your student profile to access video lectures, certificates, and learning telemetry.</p>

                    <!-- Tabs -->
                    <ul class="nav nav-pills nav-justified mb-4 p-1 bg-slate-100 rounded-3" id="authTabs">
                        <li class="nav-item">
                            <button class="nav-link active font-heading fw-bold py-2 rounded-3" id="tabRegisterBtn" data-bs-toggle="pill" data-bs-target="#tabRegister">Create New Account</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link font-heading fw-bold py-2 rounded-3" id="tabLoginBtn" data-bs-toggle="pill" data-bs-target="#tabLogin">Sign In Existing</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="authTabContent">
                        <!-- Tab 1: Create New Account -->
                        <div class="tab-pane fade show active" id="tabRegister">
                            <form action="<?= Url::to('/courses/' . $course['slug'] . '/register-and-buy') ?>" method="POST" class="space-y-3">
                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                                <input type="hidden" name="tier" value="<?= Security::e($tier) ?>">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-slate-800 fw-semibold small">First Name *</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="e.g. Rahul" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-slate-800 fw-semibold small">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="Sharma">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-slate-800 fw-semibold small">Email Address *</label>
                                    <input type="email" name="email" class="form-control" placeholder="rahul@example.com" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-slate-800 fw-semibold small">Phone / WhatsApp Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+91 98765 43210">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-slate-800 fw-semibold small">Create Account Password *</label>
                                    <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                                </div>

                                <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                                    Create Account & Proceed to Payment <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Tab 2: Sign In -->
                        <div class="tab-pane fade" id="tabLogin">
                            <form action="<?= Url::to('/login') ?>" method="POST" class="space-y-3">
                                <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">

                                <div class="mb-3">
                                    <label class="form-label text-slate-800 fw-semibold small">Account Email *</label>
                                    <input type="email" name="email" class="form-control" placeholder="rahul@example.com" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-slate-800 fw-semibold small">Account Password *</label>
                                    <input type="password" name="password" class="form-control" placeholder="Your account password" required>
                                </div>

                                <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                                    Sign In & Continue Order <i class="bi bi-box-arrow-in-right ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
