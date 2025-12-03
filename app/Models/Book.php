<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends BaseModel
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'price', 'plot', 'published_at', 'collection_id'];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'price' => 'decimal:2',
        'plot' => 'string',
        'published_at' => 'datetime',
        'collection_id' => 'integer',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'authors_books');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'model', 'has_types');
    }

    public function quantities()
    {
        return $this->hasMany(BookQuantity::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'books_quantity')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Get total quantity across all locations
    public function getTotalQuantityAttribute()
    {
        return $this->quantities()->sum('quantity');
    }
}
