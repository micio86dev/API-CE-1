<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'publishedAt' => $this->published_at,
            'collection' => $this->collection,
            'types' => $this->types,
            'authors' => $this->authors,
        ];
    }
}
