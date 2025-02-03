<?php

namespace App\Enums;

enum SleepingEnum: string
{
    case NOT_ARRANGED = 'not_arranged';
    case NOT_OVERNIGHT = 'not_overnight';
    case PRIVATE_ROOMS = 'private_rooms';
    case SHARED_ROOM = 'shared_room';
    case SHARED_ROOM_AND_CAMPING = 'shared_room_and_camping';
}
