<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Ranges\DateRange;

interface FetcherInterface
{
    public function pull(DateRange $range): \Iterator;

    public function fetchDataType(DataType $type): bool;
}
