<?php

namespace App\Services\Fetchers;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Fetchers\Contracts\FetcherInterface;
use App\Services\Fetchers\Contracts\RecordsExtractorInterface;
use App\Services\Fetchers\Contracts\SourceDescriptorInterface;
use App\Services\Fetchers\Contracts\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;
use GuzzleHttp\Client;

class RecordsFetcher implements FetcherInterface
{
    use CreatesRecordsIterator;
    public function __construct(
        private readonly Client $client,
        private readonly SourceDescriptorInterface $source,
        private readonly RecordsExtractorInterface $recordsExtractor
    )
    {
    }

    protected function getSourceDescriptor(): SourceDescriptorInterface
    {
        return $this->source;
    }

    public function fetchDataType(DataType $type): bool
    {
        return $this->source->isDataTypeSource($type);
    }


    public function fetch(DateRange $range): array
    {
        $records = [];

        $response = $this->client->get($this->source->getResourceUrl());
        $responseContent = json_decode($response->getBody(), true);


        if ($this->source instanceof SourceListDescriptorInterface) {
            foreach ($responseContent as $file) {
                $resourceToExtract = $this->source->getResourceToExtract($file);
                if ($this->source->isValidSource($resourceToExtract, $range)) {
                    $records = array_merge($records, $this->recordsExtractor->extractRecords($resourceToExtract));
                }
            }
        } else {
            $resourceToExtract = $this->source->getResourceToExtract($responseContent);
            $records = $this->recordsExtractor->extractRecords($resourceToExtract);
        }

        return $records;
    }
}
