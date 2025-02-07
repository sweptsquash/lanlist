<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Organiser */
class OrganiserResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'website' => $this->website,
            'steam_group_url' => $this->steam_group_url,
            'blurb' => $this->blurb,
            'is_published' => $this->is_published,
            'use_favicon' => $this->use_favicon,
            'assumed_stale_at' => $this->assumed_stale_at,
            'events' => EventResource::collection($this->whenLoaded('events')),
            'events_count' => $this->whenCounted('events_count'),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'requests' => OrganiserJoinRequestResource::collection($this->whenLoaded('joinRequests')),
            'logo' => $this->whenLoaded('media', function () {
                return MediaResource::make($this->getFirstMedia('logo'));
            }),
            'favicon' => $this->whenLoaded('media', function () {
                return MediaResource::make($this->getFirstMedia('favicon'));
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
