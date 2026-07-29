<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\Coupon;

class MarketingAutomationService extends Service
{
    public function validateCoupon(string $code, float $cartAmount): array
    {
        $coupon = (new Coupon())->findValidCode($code);
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired discount coupon code.'];
        }

        $discount = 0.0;
        if ($coupon['discount_type'] === 'percentage') {
            $discount = round(($cartAmount * (float)$coupon['discount_value']) / 100, 2);
        } else {
            $discount = min((float)$coupon['discount_value'], $cartAmount);
        }

        $finalAmount = max(0.0, round($cartAmount - $discount, 2));

        return [
            'valid' => true,
            'code' => $coupon['code'],
            'discount' => $discount,
            'final_amount' => $finalAmount
        ];
    }
}
