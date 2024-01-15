<?php

namespace App\Services\Fetchers\RecordsExtractors;

use App\Services\Fetchers\Contracts\RecordsExtractorInterface;
use GuzzleHttp\Client;

class CsvExtractor implements RecordsExtractorInterface
{
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function extractRecords(string|array $resource): array
    {
        $records = [];
        $fileHandle = fopen($resource, 'r');

        $header = [];
        $i = 0;
        while (false !== $row = fgetcsv($fileHandle)) {

            if ($i === 0) {
                $header = $row;
            } else {
                $record = [];
                foreach ($header as $c => $key) {
                    $record[$key] = $row[$c];
                }
                $records[] = $record;
            }

            $i++;
        }

        return $records;
    }

}
