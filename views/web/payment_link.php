<div class="hero-light py-5">
    <div class="container py-2 text-center">
        <span class="badge-pill-accent mb-2"><i class="bi bi-shield-check me-1"></i> SECURE ENROLLMENT PAYMENT</span>
        <h1 class="display-5 font-heading fw-extrabold text-slate-900 mb-3">Statutory 18% GST Tuition Fee Checkout</h1>
        <p class="lead text-slate-600 mb-0 mx-auto" style="max-width: 640px;">
            Complete your enrollment payment for <strong><?= Security::e($link['course_title']) ?></strong>.
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-edtech p-4 p-md-5 bg-white border-slate-200 shadow-lg">
                <div class="border-bottom border-slate-200 pb-3 mb-4">
                    <span class="badge bg-primary text-white font-monospace mb-2">LINK CODE: <?= Security::e($link['link_code']) ?></span>
                    <h3 class="h4 font-heading fw-bold text-slate-900 mb-1"><?= Security::e($link['course_title']) ?></h3>
                    <div class="small text-slate-500 font-monospace">Target Cohort: <?= Security::e($link['batch_name'] ?? 'Cohort Alpha 2026') ?></div>
                </div>

                <div class="p-3 bg-slate-50 rounded-3 border border-slate-200 font-monospace small mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">Student Billed:</span>
                        <span class="fw-bold text-slate-900"><?= Security::e($link['first_name'] . ' ' . $link['last_name']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">Email:</span>
                        <span class="text-slate-900"><?= Security::e($link['email']) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">Base Tuition Subtotal:</span>
                        <span class="text-slate-900">₹ <?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-600">Statutory 18% GST (SAC 999293):</span>
                        <span class="text-slate-900">₹ <?= number_format($gst, 2) ?></span>
                    </div>
                    <hr class="my-2 border-slate-200">
                    <div class="d-flex justify-content-between fs-6 fw-bold">
                        <span class="text-slate-900">Total Payable Amount:</span>
                        <span class="text-primary fs-4">₹ <?= number_format((float)$link['amount'], 2) ?></span>
                    </div>
                </div>

                <form action="<?= Url::to('/pay/' . $link['link_code']) ?>" method="POST">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    
                    <div class="mb-4">
                        <label class="form-label font-heading fw-bold text-slate-900 small">Select Payment Method</label>
                        <div class="form-check p-3 bg-slate-50 rounded-3 border mb-2">
                            <input class="form-check-input ms-1" type="radio" name="gateway" id="gateRazorpay" value="razorpay" checked>
                            <label class="form-check-label ms-2 fw-bold text-slate-900" for="gateRazorpay">
                                Razorpay / UPI / Credit & Debit Cards / NetBanking
                            </label>
                        </div>
                        <div class="form-check p-3 bg-slate-50 rounded-3 border">
                            <input class="form-check-input ms-1" type="radio" name="gateway" id="gateCashfree" value="cashfree">
                            <label class="form-check-label ms-2 fw-bold text-slate-900" for="gateCashfree">
                                Cashfree Instant UPI / EMI Options
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                        <i class="bi bi-lock-fill me-1"></i> Pay ₹ <?= number_format((float)$link['amount'], 2) ?> & Activate Enrollment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
