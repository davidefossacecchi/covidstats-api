<?php

namespace App\Services\Connectors\Contracts;

enum DataType: string
{
    case PROVINCE = 'province_data';
    case REGION = 'region_data';
    case COUNTRY = 'country_data';
}
