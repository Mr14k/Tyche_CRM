<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class MediaFile extends Model
{
    protected string $table = 'media_files';

    public function getByFolder(string $folder = 'all'): array
    {
        if ($folder === 'all') {
            return $this->all();
        }
        return $this->findWhere('folder', $folder);
    }
}
