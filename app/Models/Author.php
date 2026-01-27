<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends BaseModel
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'authors_books');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
