<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city',
        'province',
        'country',
        'street',
        'street_number',
        'zip',
        'lat',
        'lng',
        'model_id',
        'model_type',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'model_id' => 'integer',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->street_number} - {$this->zip} {$this->city} ({$this->province})";
    }
}
