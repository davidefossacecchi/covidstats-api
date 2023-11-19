<?php

namespace App\Services\Connectors\Contracts;

enum DataTypes: string
{
    case PROVINCE = 'province_data';
    case REGION = 'region_data';
    case COUNTRY = 'country_data';
}
