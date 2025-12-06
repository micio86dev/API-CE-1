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
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'types' => TypeResource::collection($this->whenLoaded('types')),
            'collection' => new CollectionResource($this->whenLoaded('collection')),
        ];
    }
}
