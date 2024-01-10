<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Ranges\DateRange;

interface FetcherInterface
{
    public function pull(DateRange $range): \Iterator;

    public function fetchDataType(DataTypes $type): bool;
}
