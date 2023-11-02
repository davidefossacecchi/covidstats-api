<?php

namespace App\Services\Fetchers\RecordsExtractors;

use App\Services\Fetchers\Contracts\RecordsExtractorInterface;

class CountriesApiExtractor implements RecordsExtractorInterface
{
    public function extractRecords(array|string $resource): array
    {
        $records = [];
        foreach ($resource as $country => $rows) {
            foreach ($rows as $row) {
                $records[] = array_merge($row, compact('country'));
            }
        }

        return $records;
    }

}
