<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class HomepageSection extends Model
{
    protected string $table = 'homepage_sections';

    public function findByKey(string $key): ?array
    {
        return $this->findOneWhere('section_key', $key);
    }
}
