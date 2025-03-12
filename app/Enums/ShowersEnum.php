<?php

declare(strict_types=1);

namespace App\Enums;

enum ShowersEnum: string
{
    case UNKNOWN = 'unknown';
    case NOT_AT_VENUE = 'not_at_venue';
    case AVAILABLE_AT_VENUE = 'available_at_venue';
}
