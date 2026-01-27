<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TypeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'alias'];

    public $translatable = ['name'];

    public function books()
    {
        return $this->morphedByMany(Book::class, 'model', 'has_types');
    }

    public function locations()
    {
        return $this->morphedByMany(Location::class, 'model', 'has_types');
    }

    public function images()
    {
        return $this->morphedByMany(Image::class, 'model', 'has_types');
    }
}
