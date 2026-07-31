<?php

declare(strict_types=1);

namespace App\Controllers\Admin\Bi;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\TenantContext;

class ReportExportController extends Controller
{
    public function exportCsv(Request $request): void
    {
        $type = (string)$request->input('type', 'admissions');
        $tid = TenantContext::getTenantId();

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=tyche_{$type}_report_" . date('Y-m-d') . ".csv");

        $out = fopen('php://output', 'w');

        if ($type === 'revenue') {
            fputcsv($out, ['Payment Reference', 'Admission No', 'Student', 'Gateway', 'Amount', 'Status', 'Date']);
            $rows = Database::fetchAll("SELECT p.payment_reference, a.admission_number, CONCAT(u.first_name, ' ', u.last_name) as student, p.gateway, p.amount, p.status, p.payment_date FROM payments p JOIN admissions a ON p.admission_id = a.id JOIN users u ON a.user_id = u.id WHERE p.tenant_id = :tid", ['tid' => $tid]);
            foreach ($rows as $r) {
                fputcsv($out, $r);
            }
        } elseif ($type === 'invoices') {
            fputcsv($out, ['Invoice Number', 'Student', 'Email', 'Subtotal', 'CGST (9%)', 'SGST (9%)', 'Total Amount', 'Issued Date']);
            $rows = Database::fetchAll("SELECT inv.invoice_number, CONCAT(u.first_name, ' ', u.last_name) as student, u.email, inv.subtotal, inv.cgst_amount, inv.sgst_amount, inv.total_amount, inv.issued_at FROM invoices inv JOIN users u ON inv.user_id = u.id WHERE inv.tenant_id = :tid", ['tid' => $tid]);
            foreach ($rows as $r) {
                fputcsv($out, $r);
            }
        } else {
            fputcsv($out, ['Lead Code', 'First Name', 'Last Name', 'Email', 'Phone', 'Source', 'Status', 'Score']);
            $rows = Database::fetchAll("SELECT lead_code, first_name, last_name, email, phone, source, status, lead_score FROM leads WHERE tenant_id = :tid", ['tid' => $tid]);
            foreach ($rows as $r) {
                fputcsv($out, $r);
            }
        }

        fclose($out);
        exit(0);
    }
}
