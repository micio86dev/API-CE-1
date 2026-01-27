<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends BaseModel
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'model');
    }

    public function types()
    {
        return $this->morphToMany(Type::class, 'model', 'has_types');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function booksQuantity()
    {
        return $this->hasMany(BookQuantity::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_quantity')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
