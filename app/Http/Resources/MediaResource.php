<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin \App\Models\Media
 */
class MediaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->file_name,
            'size' => $this->size,
            'mime_type' => $this->mime_type,
            'collection_name' => $this->collection_name,
            'human_size' => humanFileSize($this->size),
            'url' => $this->getTemporaryUrl(now()->addMinutes(config('app.media_url_expires_after_minutes'))),
            'conversions' => $this->getConversions(),
            'path' => $this->getPath(),
            'created_at' => $this->created_at,
        ];
    }

    private function getConversions(): Collection
    {
        return $this->getGeneratedConversions()
            ->filter()
            ->map(function ($value, $conversion) {
                return [
                    [
                        'name' => $conversion,
                        'url' => $this->getUrl($conversion),
                    ],
                ];
            })
            ->flatten(1);
    }
}
