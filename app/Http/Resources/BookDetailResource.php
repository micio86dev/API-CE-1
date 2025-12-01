<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'plot' => $this->plot,
            'publishedAt' => $this->published_at,
            'types' => $this->types,

            'collection' => $this->collection,

            'authors' => $this->authors,

            'locations' => $this->locations,

            'totalBookQuantity' => $this->locations->sum('pivot.quantity'),
        ];
    }
}
