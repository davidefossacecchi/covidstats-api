<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Ranges\DateRange;

interface DataLoaderInterface
{
    public function load(LocalityType $type, int $localityId, DateRange $range): array;

    public function getMaxDateForCollection(DataType $types): ?\DateTimeInterface;
}
