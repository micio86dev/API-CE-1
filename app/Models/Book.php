<?php

namespace App\Models;

use App\Models\BaseModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends BaseModel
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'price', 'plot', 'published_at', 'collection_id'];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:2',
        'published_at' => 'datetime',
        'collection_id' => 'integer',
        'total_quantity' => 'integer',
    ];

    protected $appends = [
        'total_quantity'
    ];

    public $translatable = ['title', 'plot'];

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
        /*if (array_key_exists('quantities_sum_quantity', $this->attributes)) {
            return (int) $this->attributes['quantities_sum_quantity'];
        }*/

        return $this->quantities()->sum('quantity');
    }
}
