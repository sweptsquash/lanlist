<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    public function __invoke(Media $media): Response
    {
        return $media->toResponse(request());
    }
}
