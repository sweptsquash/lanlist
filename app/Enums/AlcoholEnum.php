<?php

namespace App\Enums;

enum AlcoholEnum: string
{
    case UNKNOWN = 'unknown';
    case NOT_ALLOWED_AT_THE_EVENT = 'not_allowed_at_the_event';
    case BRING_YOUR_OWN_ALCOHOL = 'bring_your_own_alcohol';
    case BAR_AT_THE_VENUE = 'bar_at_the_venue';
    case BAR_AT_THE_VENUE_AND_BRING_YOUR_OWN_ALCOHOL = 'bar_at_the_venue_and_bring_your_own_alcohol';
}
