<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'email' => $this->when(user() && user()->is($this->getModel()), $this->email),
            'date_format' => $this->date_format,
            'timezone' => $this->timezone,
            'twitch_id' => $this->when(user() && user()->is($this->getModel()), $this->twitch_id),
            'discord_id' => $this->when(user() && user()->is($this->getModel()), $this->discord_id),
            'ip' => $this->when(user()->is($this->getModel()), $this->ip),
            'profile_photo' => $this->profile_photo,
            'email_verified_at' => $this->email_verified_at,
            'password_changed_at' => $this->password_changed_at,
            'last_active_at' => $this->last_active_at,
            'organiser' => OrganiserResource::make($this->whenLoaded('organiser')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
