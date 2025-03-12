<?php

declare(strict_types=1);

namespace App\Enums;

enum SmokingEnum: string
{
    case UNKNOWN = 'unknown';
    case OUTSIDE_VENUE = 'outside_venue';
    case SMOKING_AREA_IN_VENUE = 'smoking_area_in_venue';
}
