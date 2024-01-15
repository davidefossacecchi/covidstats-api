<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Ranges\DateRange;

interface SourceListDescriptorInterface
{
    /**
     * Tells if a subresource is a valid source or should be skipped
     */
    public function isValidSource(string|array $source, DateRange $range): bool;
}
