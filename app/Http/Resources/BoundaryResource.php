<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoundaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'boundary_uid' => $this->boundary_uid,
            'name' => $this->name,
            'level' => $this->level,
            'country' => new CountryResource($this->country),
        ];
    }
}
