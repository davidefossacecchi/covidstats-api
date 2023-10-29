<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Ranges\DateRange;

interface SourceListDescriptorInterface
{
    public function isValidSource(string|array $source): bool;
}
