<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Ranges\DateRange;
use App\Services\Connectors\Exceptions\NotFoundLocalityException;
interface DataLoaderInterface
{
    /**
     * Loads data for a specific locality in a date range
     * @throw NotFoundLocalityException
     */
    public function load(LocalityType $type, int $localityId, DateRange $range): array;

    /**
     * Returns the most recent date for a data collection
     */
    public function getMaxDateForCollection(DataType $types): ?\DateTimeInterface;
}
