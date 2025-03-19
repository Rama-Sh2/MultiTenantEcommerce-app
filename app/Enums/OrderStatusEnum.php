<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case PENDING = 1;
    case CONFIRMED = 2;
    case PROGRESS = 3;
    case CANCELED = 4;
    case COMPLETED = 5;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
