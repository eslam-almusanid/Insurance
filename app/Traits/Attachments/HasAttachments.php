<?php

namespace App\Traits\Attachments;

use App\Models\Attachment;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;

trait HasAttachments
{
    use FileUploadTrait,
    Base64UploadTrait;

    public abstract function attachmentPath(): string;
    public function attachment(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function hasAttachment(): bool
    {
        return $this->attachment()->exists();
    }

    public function addAttachment(UploadedFile $file, ?string $collection = null, string $disk = 'local'): Attachment
    {
        if (!in_array($disk, array_keys(config('filesystems.disks')))) {
            throw new Exception("Storage disk '{$disk}' does not exist");
        }
        $path = $this->attachmentPath();
        if (!is_null($collection)) {
            $path = $path . '/' . $collection;
        }
        $attachment = $this->uploadFile($file, $path, $disk);

        try {
            $submitable = request()->user();
            return $this->attachment()->create([
                'attachmentable_id' => $this->id,
                'attachmentable_type' => $this->getMorphClass(),
                'name' => $attachment['generated_name'],
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'collection_name' => $collection,
                'full_path' => $attachment['full_path'],
                'disk' => $attachment['disk'],
                'size' => $file->getSize(),
                'submitable_id' => $submitable->id,
                'submitable_type' => $submitable->getMorphClass(),
            ]);
        } catch (\Exception $e) {
            // Clean up the uploaded file if record creation fails
            $this->destroyFile($attachment['full_path'], $disk);
            logger()->error('Failed to create attachment record: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Upload multiple attachment files
     * @throws Exception
     */
    public function addMultipleAttachment(array $files, ?string $collection = null, string $disk = 'local'): Collection
    {
        if (!in_array($disk, array_keys(config('filesystems.disks')))) {
            throw new Exception("Storage disk '{$disk}' does not exist");
        }

        $attachmentItems = new Collection();
        $uploadedAttachment = new Collection();

        try {
            foreach ($files as $file) {
                if (!$file instanceof UploadedFile) {
                    continue;
                }
                $attachmentItem = $this->addAttachment($file, $collection, $disk);
                $attachmentItems->push($attachmentItem);
                $uploadedAttachment->push($attachmentItem);
            }

            return $attachmentItems;
        } catch (\Exception $e) {
            // Clean up any successfully uploaded files if an error occurs
            foreach ($uploadedAttachment as $attachmentItem) {
                $attachmentItem->delete();
            }
            logger()->error('Failed to uploadAttachment multiple attachment: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Delete attachment by ID or all attachments
     * @throws Exception
     */
    public function deleteAttachment(?int $id = null, string $disk = 'local'): bool
    {
        try {
            $attachment = $this->attachment();

            if ($id) {
                $attachment = $attachment->where('id', $id)->firstOrFail();
                $this->destroyFile($attachment->full_path, $disk);
                return $attachment->delete();
            }

            // Delete all attachments
            $this->deleteAttachmentStorage($disk);
            return $attachment->delete();
        } catch (\Exception $e) {
            logger()->error('Failed to delete attachment: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteAttachmentStorage($disk = 'local')
    {
        if (Storage::exists($this->attachmentPath())) {
            Storage::disk($disk)->deleteDirectory($this->attachmentPath());
        }
    }

    public function addBase64Attachment(string $base64File, ?string $collection = null, string $disk = 'local'): Attachment
    {
        $path = $this->attachmentPath();
        if (!is_null($collection)) {
            $path = $path . '/' . $collection;
        }

        try {
            $fileInfo = $this->uploadBase64File($base64File, $path, $disk);
            
            $submitable = request()->user();
            return $this->attachment()->create([
                'attachmentable_id' => $this->id,
                'attachmentable_type' => $this->getMorphClass(),
                'name' => $fileInfo['name'],
                'original_name' => $fileInfo['original_name'],
                'mime_type' => $fileInfo['mime_type'],
                'collection_name' => $collection,
                'full_path' => $fileInfo['full_path'],
                'disk' => $fileInfo['disk'],
                'size' => $fileInfo['size'],
                'submitable_id' => $submitable?->id,
                'submitable_type' => $submitable ? $submitable->getMorphClass() : null,
            ]);
        } catch (\Exception $e) {
            // Clean up the uploaded file if record creation fails
            if (isset($fileInfo['full_path'])) {
                $this->destroyFile($fileInfo['full_path'], $disk);
            }
            logger()->error('Failed to create base64 attachment: ' . $e->getMessage());
            throw $e;
        }
    }
}