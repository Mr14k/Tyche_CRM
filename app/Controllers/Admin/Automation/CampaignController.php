<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Automation;

use App\Core\Controller;
use App\Core\Request;
use App\Models\MarketingCampaign;
use App\Models\Referral;
use App\Helpers\Flash;
use App\Helpers\Url;

class CampaignController extends Controller
{
    public function index(Request $request): void
    {
        $campaigns = (new MarketingCampaign())->all();
        $referrals = (new Referral())->all();

        $this->view('admin.automation.campaigns', [
            'pageTitle' => 'Marketing Automation & Referral Engine — Tyche Academy',
            'campaigns' => $campaigns,
            'referrals' => $referrals
        ], 'admin');
    }

    public function store(Request $request): void
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'channel' => 'required',
            'template' => 'required'
        ]);

        (new MarketingCampaign())->create([
            'title' => $data['title'],
            'channel' => $data['channel'],
            'subject' => $request->input('subject'),
            'content_template' => $data['template'],
            'target_segment' => $request->input('segment', 'all_leads'),
            'status' => 'scheduled',
            'scheduled_at' => date('Y-m-d H:i:s')
        ]);

        Flash::success("Automated campaign '{$data['title']}' scheduled.");
        $this->redirect(Url::to('/admin/automation/campaigns'));
    }
}
