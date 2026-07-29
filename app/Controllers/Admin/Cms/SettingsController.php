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
            'pageTitle' => 'Global Site Settings — Tyche Academy',
            'settings' => $settings
        ], 'admin');
    }

    public function update(Request $request): void
    {
        $settingsToSave = [
            'site_name', 'contact_email', 'contact_phone', 'address', 
            'footer_copyright', 'google_analytics_id', 'google_tag_manager_id', 
            'meta_pixel_id', 'custom_header_scripts', 'maintenance_mode'
        ];

        foreach ($settingsToSave as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        Flash::success('Global site settings updated successfully.');
        $this->redirect(Url::to('/admin/cms/settings'));
    }
}
