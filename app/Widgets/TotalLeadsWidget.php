<?php

declare(strict_types=1);

namespace App\Widgets;

use App\Core\WidgetInterface;
use App\Core\Database;

class TotalLeadsWidget implements WidgetInterface
{
    public function getKey(): string
    {
        return 'total_leads';
    }

    public function getTitle(): string
    {
        return 'Inquiries & Submissions';
    }

    public function getRequiredPermission(): ?string
    {
        return 'CMS.ManageForms';
    }

    public function render(): string
    {
        $res = Database::fetchOne("SELECT COUNT(*) as cnt FROM form_submissions WHERE status = 'new'");
        $count = $res ? (int)$res['cnt'] : 0;

        return '<div class="card-custom p-4">
            <div class="text-muted small text-uppercase font-monospace">New Form Inquiries</div>
            <div class="display-6 font-monospace text-info mt-2">' . $count . '</div>
            <div class="text-secondary small mt-1"><i class="bi bi-inbox"></i> Pending CRM Ingestion</div>
        </div>';
    }
}
