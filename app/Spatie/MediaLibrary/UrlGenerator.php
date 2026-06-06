<?php

declare(strict_types=1);

namespace App\Spatie\MediaLibrary;

use DateTimeInterface;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

final class UrlGenerator extends DefaultUrlGenerator
{
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        abort_if(is_null($this->media), 404, 'Media not found');

        if (config('filesystems.disks.media.driver') === 's3') {
            return $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), $expiration, $options);
        }

        return URL::temporarySignedRoute(
            'media.show',
            $expiration,
            ['media' => $this->media->uuid, 'filename' => $this->media->name],
        );
    }
}
