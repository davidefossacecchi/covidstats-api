<?php

namespace App\Services\Fetchers\SourceFilters;

/**
 * Filters the passed resources list
 */
interface SourceFilterInterface
{
    public function accept(string $path, \DateTime $from = null, \DateTime $to = null): bool;
}
