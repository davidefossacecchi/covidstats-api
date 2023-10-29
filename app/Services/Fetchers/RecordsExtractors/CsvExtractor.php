<?php

namespace App\Services\Fetchers\RecordsExtractors;

use App\Services\Ranges\DateRange;
use GuzzleHttp\Client;

class CsvExtractor implements RecordsExtractorInterface
{
    public function extractRecords(string|array $resource, DateRange $range): array
    {
        $records = [];
        $client = new Client();
        $response = $client->get($resource);
        $content = $response->getBody();
        $rows = explode("\n", $content);
        $header = [];
        foreach ($rows as $i => $row) {
            // this is the last line
            if (empty($row)) {
                break;
            }
            $cells = str_getcsv($row);
            if ($i === 0) {
                $header = $cells;
            } else {
                $record = [];
                foreach ($header as $i => $key) {
                    $record[$key] = $cells[$i];
                }
                $records[] = $record;
            }
        }

        return $records;
    }

}
