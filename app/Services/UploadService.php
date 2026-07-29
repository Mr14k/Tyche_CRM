<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Exceptions\ValidationException;

class UploadService extends Service
{
    private array $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf'
    ];

    public function uploadAvatar(array $file): string
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(['avatar' => ['File upload failed or missing.']]);
        }

        // Max 2MB
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new ValidationException(['avatar' => ['Avatar image size cannot exceed 2MB.']]);
        }

        // Validate MIME type securely using finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!array_key_exists($mime, $this->allowedMimes) || !str_starts_with($mime, 'image/')) {
            throw new ValidationException(['avatar' => ['Invalid image file type. Allowed: JPG, PNG, WEBP.']]);
        }

        $extension = $this->allowedMimes[$mime];
        $filename = 'avatar_' . bin2hex(random_bytes(16)) . '.' . $extension;

        $targetDir = dirname(__DIR__, 2) . '/storage/uploads/avatars';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception("Failed to save uploaded avatar.");
        }

        return 'avatars/' . $filename;
    }
}
