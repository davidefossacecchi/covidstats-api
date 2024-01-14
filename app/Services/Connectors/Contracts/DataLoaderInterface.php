<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Ranges\DateRange;

interface DataLoaderInterface
{
    public function load(array $localityIds, DateRange $range): array;

    public function getMaxDateForCollection(DataType $types): ?\DateTimeInterface;
}
