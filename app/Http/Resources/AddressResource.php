<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'street' => $this->street,
            'street_number' => $this->street_number,
            'zip' => $this->zip,
            'model' => $this->model,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
