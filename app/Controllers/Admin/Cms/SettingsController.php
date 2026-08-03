<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Cms;

use App\Core\Controller;
use App\Core\Request;
use App\Models\SiteSetting;
use App\Helpers\Flash;
use App\Helpers\Url;

class SettingsController extends Controller
{
    public function index(Request $request): void
    {
        $settings = SiteSetting::getAllAsMap();

        $this->view('admin.cms.settings', [
            'pageTitle' => 'Global Site & Payment Settings — Tyche Academy',
            'settings' => $settings
        ], 'admin');
    }

    public function update(Request $request): void
    {
        $settingsToSave = [
            'site_name', 'contact_email', 'contact_phone', 'address', 
            'footer_copyright', 'google_analytics_id', 'google_tag_manager_id', 
            'meta_pixel_id', 'custom_header_scripts', 'maintenance_mode',
            // Independent Tenant Payment Gateway Settings
            'payment_active_gateway', 'payment_currency',
            'razorpay_key_id', 'razorpay_key_secret', 'razorpay_webhook_secret',
            'stripe_publishable_key', 'stripe_secret_key', 'stripe_webhook_secret',
            'payment_upi_id', 'payment_bank_details'
        ];

        foreach ($settingsToSave as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        Flash::success('Global site & payment gateway settings updated successfully.');
        $this->redirect(Url::to('/admin/cms/settings'));
    }
}
