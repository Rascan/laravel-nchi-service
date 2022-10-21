<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JurisdictionResource extends JsonResource
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
            'jurisdiction_uid' => $this->jurisdiction_uid,
            'name' => $this->name,
            'boundary' => new BoundaryResource($this->whenLoaded('boundary')),
            'parent' => new JurisdictionResource($this->whenLoaded('parent')),
        ];
    }
}
