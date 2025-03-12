<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Event */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'blurb' => $this->blurb,
            'website' => $this->website,
            'image_url' => $this->image_url,
            'price_on_door' => $this->price_on_door,
            'price_in_adv' => $this->price_in_adv,
            'currency' => $this->currency,
            'age_restrictions' => $this->age_restrictions,
            'sleeping' => $this->sleeping,
            'alcohol' => $this->alcohol,
            'smoking' => $this->smoking,
            'showers' => $this->showers,
            'seats' => $this->seats,
            'network_mbps' => $this->network_mbps,
            'internet_mbps' => $this->internet_mbps,
            'is_published' => $this->is_published,
            'banner' => $this->whenLoaded('media', function () {
                return MediaResource::make($this->getFirstMedia('banner'));
            }),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'organiser' => OrganiserResource::make($this->whenLoaded('organiser')),
            'venue' => VenueResource::make($this->whenLoaded('venue')),
            'reviews' => EventReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
