<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Automation;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Coupon;
use App\Helpers\Flash;
use App\Helpers\Url;

class CouponController extends Controller
{
    public function index(Request $request): void
    {
        $coupons = (new Coupon())->all();
        $this->view('admin.automation.coupons', [
            'pageTitle' => 'Discount Coupons & Scholarships — Tyche Academy',
            'coupons' => $coupons
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'code' => 'required',
            'discount_value' => 'required|numeric'
        ]);

        (new Coupon())->create([
            'code' => strtoupper($data['code']),
            'discount_type' => $request->input('discount_type', 'percentage'),
            'discount_value' => (float)$data['discount_value'],
            'max_uses' => (int)$request->input('max_uses', 100),
            'expires_at' => date('Y-m-d', strtotime('+30 days')),
            'is_active' => 1
        ]);

        Flash::success("Discount coupon '{$data['code']}' created with 30-day default expiry.");
        $this->redirect(Url::to('/admin/automation/coupons'));
    }
}
