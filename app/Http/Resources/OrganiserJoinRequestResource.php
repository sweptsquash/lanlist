<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\OrganiserJoinRequest */
class OrganiserJoinRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organiser' => OrganiserResource::make($this->whenLoaded('organiser')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'comments' => $this->comments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
