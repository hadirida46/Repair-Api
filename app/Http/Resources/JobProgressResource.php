<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobProgressResource extends JsonResource
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
            'report_id' => $this->report_id,
            'specialist_comment' => $this->specialist_comment,
            'user_comment' => $this->user_comment,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
