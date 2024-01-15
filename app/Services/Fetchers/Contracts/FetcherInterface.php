<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Ranges\DateRange;

interface FetcherInterface
{
    /**
     * Retrieves data in a specific date range
     */
    public function pull(DateRange $range): \Iterator & \Countable;

    /**
     * Tells if a fetcher is able to fetch a specific data type
     */
    public function fetchDataType(DataType $type): bool;
}
