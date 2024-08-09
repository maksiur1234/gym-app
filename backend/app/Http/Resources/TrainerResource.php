<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'surname' => $this->resource->surname,
            'desc' => $this->resource->desc,
            'profile_photo_path' => $this->resource->profile_photo_path,
            'email' => $this->resource->email,
            'role' => $this->resource->role,
            //add more data to array which we want to return
        ];
    }
}
