<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Attachment extends Model
{
    use HasUuids,
        HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'mime_type',
        'full_path',
        'disk',
        'collection_name',
        'custom_properties',
        'size',
        'submitable_id',
        'submitable_type',
        'attachmentable_id',
        'attachmentable_type',
    ];

    public function submitable()
    {
        return $this->morphTo();
    }

    public function attachmentable()
    {
        return $this->morphTo();
    }
}