<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Ranges\DateRange;

interface FetcherInterface
{
    public function pull(DateRange $range): \Iterator;
}
