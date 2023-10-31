<?php

namespace App\Services\Fetchers\RecordsExtractors;

use App\Services\Ranges\DateRange;

/**
 * Extract the records from the resource
 */
interface RecordsExtractorInterface
{
    public function extractRecords(string|array $resource): array;
}
