<?php

namespace App\Services\Connectors\Contracts;

enum LocalityTypes: int
{
    case PROVINCE = 0;
    case REGION = 1;
    case COUNTRY = 2;
}
