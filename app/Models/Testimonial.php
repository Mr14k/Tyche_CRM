<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Testimonial extends Model
{
    protected string $table = 'testimonials';

    public function getApprovedFeatured(): array
    {
        $sql = "SELECT * FROM testimonials WHERE status = 'approved' AND is_featured = 1 ORDER BY sort_order ASC";
        return Database::fetchAll($sql);
    }
}
