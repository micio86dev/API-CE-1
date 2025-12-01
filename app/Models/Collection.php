<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends BaseModel
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'name', 'description', 'published_at'];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'published_at' => 'datetime',
    ];

    public function book(){
        return $this->hasMany(Book::class);
    }
}

