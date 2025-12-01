<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BookQuantity extends BaseModel
{
    use HasFactory;

    protected $table = 'books_quantity';

    protected $fillable = [
        'book_id',
        'location_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}