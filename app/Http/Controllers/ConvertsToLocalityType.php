<?php

namespace App\Http\Controllers;

use App\Services\Connectors\Contracts\LocalityType;

trait ConvertsToLocalityType
{
    protected function convertToLocalityType(string $localityKey): ?LocalityType
    {
        return match ($localityKey) {
            'provinces' => LocalityType::PROVINCE,
            'regions' => LocalityType::REGION,
            'countries' => LocalityType::COUNTRY,
            default => null
        };
    }
}
