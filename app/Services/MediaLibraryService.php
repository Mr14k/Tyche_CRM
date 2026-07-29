<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Service;
use App\Models\MediaFile;
use App\Exceptions\ValidationException;

class MediaLibraryService extends Service
{
    private MediaFile $mediaModel;

    public function __construct()
    {
        $this->mediaModel = new MediaFile();
    }

    public function upload(array $file, int $uploaderId, string $folder = 'uncategorized', ?string $tags = null): array
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(['file' => ['File upload failed or missing.']]);
        }

        // Validate MIME type securely
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $fileType = 'document';
        if (str_starts_with($mime, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($mime, 'video/')) {
            $fileType = 'video';
        }

        // Organize into YYYY/MM subfolders as per user directive
        $yearMonth = date('Y/m');
        $targetDir = dirname(__DIR__, 2) . '/storage/uploads/cms/' . $yearMonth;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'media_' . bin2hex(random_bytes(12)) . ($extension ? '.' . $extension : '');
        $targetPath = $targetDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception("Failed to store uploaded media file.");
        }

        $relativePath = 'cms/' . $yearMonth . '/' . $filename;
        $mediaId = $this->mediaModel->create([
            'original_name' => $file['name'],
            'file_path' => $relativePath,
            'file_type' => $fileType,
            'mime_type' => $mime,
            'file_size' => $file['size'],
            'folder' => $folder,
            'tags' => $tags,
            'uploaded_by' => $uploaderId
        ]);

        return $this->mediaModel->find((int)$mediaId);
    }
}
