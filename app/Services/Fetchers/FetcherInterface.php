<?php

namespace App\Services\Fetchers;

use App\Services\Ranges\DateRange;

interface FetcherInterface
{
    public function pull(DateRange $range): \Iterator;
}
