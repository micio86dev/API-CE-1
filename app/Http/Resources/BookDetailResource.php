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
            'collection' => new CollectionResource($this->whenLoaded('collection')),
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'types' => TypeResource::collection($this->whenLoaded('types')),
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
        ];
    }
}
