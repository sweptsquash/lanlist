<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Facades\Request;
use Intervention\Image\Laravel\Facades\Image;

class MediaConversionController extends Controller
{
    public function __invoke(Request $request, Media $media)
    {
        $thumbnail = $media->getPath('thumb');

        return Image::read($thumbnail)->encode();
    }
}
