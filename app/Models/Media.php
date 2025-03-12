<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasCreator;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

/**
 * @mixin IdeHelperMedia
 */
class Media extends BaseMedia
{
    use HasCreator;

    public function getContent(): ?string
    {
        $path = $this->getPathRelativeToRoot();

        if (! Storage::disk($this->disk)->exists($path)) {
            return null;
        }

        return Storage::disk($this->disk)->get($path);
    }

    public function getBase64String(): ?string
    {
        if (is_null($content = $this->getContent())) {
            return null;
        }

        $type = pathinfo(
            $this->getPathRelativeToRoot(),
            PATHINFO_EXTENSION
        );

        return 'data:application/'.$type.';base64,'.base64_encode($content);
    }

    public function getMd5Hash(): ?string
    {
        if (is_null($content = $this->getContent())) {
            return null;
        }

        return md5($content);
    }
}
