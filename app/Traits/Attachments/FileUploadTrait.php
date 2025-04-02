<?php

namespace App\Traits\Attachments;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

trait FileUploadTrait
{
    /**
     * Upload a file to storage
     * @throws Exception
     */
    public function uploadFile(UploadedFile $file, string $path = "uploads", string $disk = 'local'): array
    {
        if (!in_array($disk, array_keys(config('filesystems.disks')))) {
            throw new Exception("Storage disk '{$disk}' does not exist");
        }

        if (!$file->isValid()) {
            throw new Exception(__('messages.attachment_uploaded_error'));
        }

        $generatedName = Uuid::uuid4() . '.' . $file->getClientOriginalExtension();
        $fullPath = trim($path, '/') . "/{$generatedName}";

        try {
            Storage::disk($disk)->put($fullPath, file_get_contents($file));
            Storage::disk($disk)->setVisibility($fullPath, 'public');

            return [
                'generated_name' => $generatedName,
                'full_path' => $fullPath,
                'disk' => $disk,
            ];
        } catch (\Exception $e) {
            logger()->error('Failed to upload file: ' . $e->getMessage());
            throw new Exception(__('messages.attachment_uploaded_error'));
        }
    }

    /**
     * Delete file(s) from storage
     */
    public function destroyFile(string|array $fullPath, string $disk = 'local'): void
    {
        if (is_array($fullPath)) {
            foreach ($fullPath as $path) {
                Storage::disk($disk)->delete($path);
            }
            return;
        }
        Storage::disk($disk)->delete($fullPath);
    }
}