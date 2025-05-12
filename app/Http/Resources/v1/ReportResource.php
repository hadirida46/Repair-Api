<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->images;
        if (is_array($images)) {
            $images = array_map(function ($image) {
                return Storage::url($image); 
            }, $images);
        }

        
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "images"=>$this->images,
            "location"=>$this->location,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "specialist_type"=>$this->specialist_type,
            "status"=>$this->status,
            "specialist_id" => $this->specialist_id,
            "specialist" => new UserResource($this->whenLoaded('specialist')), 
            "user" => new UserResource($this->whenLoaded('user')),
        ];
    }
}
