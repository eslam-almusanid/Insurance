<?php

namespace App\Traits\Attachments;

use Exception;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

trait Base64UploadTrait
{
    /**
     * Upload a base64 encoded file to storage
     *
     * @param string $base64File Base64 encoded file data
     * @param string $path Storage path
     * @param string $disk Storage disk
     * @return array File information including path, name, and mime type
     * @throws Exception
     */
    public function uploadBase64File(string $base64File, string $path, string $disk = 'local'): array
    {
        if (!in_array($disk, array_keys(config('filesystems.disks')))) {
            throw new Exception("Storage disk '{$disk}' does not exist");
        }

        // Validate and extract base64 data
        if (!preg_match('/^data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+);base64,/', $base64File, $matches)) {
            throw new Exception('Invalid base64 file format');
        }

        // Extract mime type
        $mimeType = $matches[1];

        // Extract file extension from mime type
        $extension = explode('/', $mimeType)[1];
        // Handle special cases
        if ($extension === 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $extension = 'xlsx';
        } else if ($extension === 'vnd.openxmlformats-officedocument.wordprocessingml.document') {
            $extension = 'docx';
        } else if ($extension === 'vnd.ms-excel') {
            $extension = 'xls';
        } else if ($extension === 'msword') {
            $extension = 'doc';
        }

        // Extract base64 data
        $base64File = substr($base64File, strpos($base64File, ',') + 1);
        $fileData = base64_decode($base64File);

        if ($fileData === false) {
            throw new Exception('Failed to decode base64 file');
        }

        // Generate unique filename
        $fileName = Uuid::uuid4() . '.' . $extension;
        $fullPath = trim($path, '/') . "/{$fileName}";

        // Store the file
        Storage::disk($disk)->put($fullPath, $fileData);
        Storage::disk($disk)->setVisibility($fullPath, 'public');

        $fileSize = Storage::disk($disk)->size($fullPath);

        return [
            'name' => $fileName,
            'original_name' => $fileName,
            'mime_type' => $mimeType,
            'full_path' => $fullPath,
            'disk' => $disk,
            'size' => $fileSize
        ];
    }
}