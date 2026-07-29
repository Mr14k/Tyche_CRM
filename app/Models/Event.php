<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Event extends Model
{
    protected string $table = 'events';

    public function getUpcoming(): array
    {
        $sql = "SELECT * FROM events WHERE is_active = 1 AND event_date >= NOW() ORDER BY event_date ASC";
        return Database::fetchAll($sql);
    }
}
