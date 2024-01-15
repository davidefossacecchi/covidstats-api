<?php

namespace App\Services\Fetchers\Contracts;

/**
 * Extract the records from the resource
 */
interface RecordsExtractorInterface
{
    /**
     * Extracts array rows from a specific resource
     */
    public function extractRecords(string|array $resource): array;
}
