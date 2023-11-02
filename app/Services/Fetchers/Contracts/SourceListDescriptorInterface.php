<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Ranges\DateRange;

interface SourceListDescriptorInterface
{
    public function isValidSource(string|array $source, DateRange $range): bool;
}
