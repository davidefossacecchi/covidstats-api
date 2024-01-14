<?php

namespace App\Services\Connectors\Contracts;

enum LocalityType: int
{
    case PROVINCE = 0;
    case REGION = 1;
    case COUNTRY = 2;
}
