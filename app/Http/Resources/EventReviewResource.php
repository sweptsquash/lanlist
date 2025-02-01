<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\EventReview */
class EventReviewResource extends JsonResource
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
            'event' => EventResource::make($this->whenLoaded('event')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'rating_venue' => $this->rating_venue,
            'rating_vfm' => $this->rating_vfm,
            'rating_activities' => $this->rating_activities,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
