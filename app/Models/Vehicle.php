<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasUuids;

    protected $fillable = [
        'sequence_number',
        'plate_char_ar',
        'plate_char_en',
        'plate_number_ar',
        'plate_number_en',
        'make',
        'model',
        'year',
        'color',
        'type',
        'modification_status',
        'vin',
        'registration_date',
        'owner_name',
        'user_id',
        'month',
        'manufacture_year',
        'status',
        'parking_location',
        'transmission_type',
        'expected_annual_mileage',
        'has_trailer',
        'used_for_racing',
        'has_modifications',
        'load',
        'price',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'manufacture_year' => 'integer',
        'has_trailer' => 'boolean',
        'used_for_racing' => 'boolean',
        'has_modifications' => 'boolean',
        'load' => 'integer',
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}