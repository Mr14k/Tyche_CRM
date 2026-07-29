<?php
// Uses layouts/web.php
?>

<div class="hero-light py-5 text-center">
    <div class="container py-4">
        <span class="badge-pill-accent mb-2"><i class="bi bi-headset me-1"></i> ADMISSIONS & SUPPORT DESK</span>
        <h1 class="display-5 font-heading fw-bold text-slate-900 mb-3">Get in Touch with Tyche Academy</h1>
        <p class="lead text-slate-600 mx-auto" style="max-width: 680px;">Have questions about course fee structures, live cohort schedules, or scholarship eligibility? Our admissions team is here to help.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <!-- Contact Information Cards -->
        <div class="col-lg-5">
            <div class="space-y-4">
                <div class="card-edtech p-4 bg-white border-slate-200 d-flex align-items-start gap-3">
                    <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="font-heading fw-bold text-slate-900 mb-1">Academy Headquarters</h5>
                        <p class="text-slate-600 small mb-0">Tyche Digital Marketing Academy HQ<br>Innovation Tower, 4th Floor, Cyber City<br>Gurugram, Haryana, India — 122002</p>
                    </div>
                </div>

                <div class="card-edtech p-4 bg-white border-slate-200 d-flex align-items-start gap-3">
                    <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-envelope-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="font-heading fw-bold text-slate-900 mb-1">Email Support</h5>
                        <p class="text-slate-600 small mb-1">Admissions: <a href="mailto:admissions@tyche.academy" class="text-primary fw-bold text-decoration-none">admissions@tyche.academy</a></p>
                        <p class="text-slate-600 small mb-0">General Support: <a href="mailto:support@tyche.academy" class="text-primary fw-bold text-decoration-none">support@tyche.academy</a></p>
                    </div>
                </div>

                <div class="card-edtech p-4 bg-white border-slate-200 d-flex align-items-start gap-3">
                    <div class="bg-primary text-white rounded-3 p-3 d-flex align-items-center justify-content-center" style="width:48px; height:48px;">
                        <i class="bi bi-telephone-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="font-heading fw-bold text-slate-900 mb-1">Phone & WhatsApp Desk</h5>
                        <p class="text-slate-900 fw-bold font-monospace mb-1">+91 98765 43210</p>
                        <p class="text-slate-500 small mb-0">Monday – Saturday: 9:00 AM – 7:00 PM IST</p>
                    </div>
                </div>

                <div class="card-edtech p-4 bg-primary-light border-primary">
                    <div class="d-flex align-items-center gap-2 text-primary font-heading fw-bold mb-1">
                        <i class="bi bi-lightning-charge-fill fs-5"></i> 2-Hour SLA Commitment
                    </div>
                    <p class="text-slate-700 small mb-0">All submitted contact form inquiries receive a counselor response within 2 business hours guaranteed.</p>
                </div>
            </div>
        </div>

        <!-- Interactive Contact / Lead Capture Form -->
        <div class="col-lg-7">
            <div class="card-edtech p-4 p-md-5 bg-white border-primary shadow-lg">
                <h3 class="h4 font-heading fw-bold text-slate-900 mb-2">Send an Inquiry Message</h3>
                <p class="text-slate-600 small mb-4">Fill in your contact details below and our counselor team will get back to you immediately.</p>

                <form action="<?= Url::to('/submit-form') ?>" method="POST" class="space-y-4">
                    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
                    <input type="hidden" name="form_type" value="contact_us">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-slate-800 fw-semibold small">Your Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="e.g. Ananya Roy" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-800 fw-semibold small">Email Address *</label>
                            <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="ananya@example.com" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-slate-800 fw-semibold small">Phone / WhatsApp Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-lg fs-6" placeholder="+91 98765 43210" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-slate-800 fw-semibold small">Inquiry Subject</label>
                            <select name="subject" class="form-select form-select-lg fs-6">
                                <option value="admissions">Course Admissions & Fee Plans</option>
                                <option value="scholarship">Scholarship & Discounts</option>
                                <option value="corporate">Corporate & Team Training</option>
                                <option value="placement">Hiring Partner / Placement Cell</option>
                                <option value="other">Other Inquiry</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-slate-800 fw-semibold small">Your Message / Questions</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Tell us how we can help you..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-edtech w-100 py-3 font-heading fw-bold fs-6">
                        Submit Contact Inquiry <i class="bi bi-send-fill ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
