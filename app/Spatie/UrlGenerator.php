<?php

declare(strict_types=1);

namespace App\Spatie;

use DateTimeInterface;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class UrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        if (config('filesystems.disks.media.driver') === 's3') {
            return $this->getDisk()->url($this->getPathRelativeToRoot());
        }

        return route('media.show', ['media' => $this->media->uuid]);
    }

    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        if (config('filesystems.disks.media.driver') === 's3') {
            return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
        }

        return URL::temporarySignedRoute(
            'media.show',
            $expiration,
            ['media' => $this->media->uuid],
        );
    }
}
