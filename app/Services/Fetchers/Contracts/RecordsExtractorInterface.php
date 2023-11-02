<?php

namespace App\Services\Fetchers\Contracts;

/**
 * Extract the records from the resource
 */
interface RecordsExtractorInterface
{
    public function extractRecords(string|array $resource): array;
}
