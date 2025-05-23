<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array

    {   
        
        return [
            "id"=>$this->id,
            "first_name"=>$this->first_name,
            "last_name"=>$this->last_name,
            "profile_image"=>$this->profile_image,
            "email"=>$this->email,
            "bio"=>$this->bio,
            "location"=>$this->location,
            "specialization"=>$this->specialization,   
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }
}
