<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends BaseModel
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_id',
        'model_type',
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'meta',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'size' => 'integer',
        'meta' => 'array',
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'model', 'has_types');
    }
}

