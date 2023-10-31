<?php

namespace App\Services\Fetchers;
use App\Services\Fetchers\RecordsExtractors\RecordsExtractorInterface;
use App\Services\Fetchers\SourceDescriptors\SourceDescriptorInterface;
use App\Services\Fetchers\SourceDescriptors\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;
use GuzzleHttp\Client;
class ApiFetcher implements FetcherInterface
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


    public function fetch(DateRange $range): array
    {
        $records = [];

        $response = $this->client->get($this->source->getResourceUrl());

        $responseContent = json_decode($response->getBody(), true);

        if ($this->source instanceof SourceListDescriptorInterface) {
            foreach ($responseContent as $subResource) {
                if ($this->source->isValidSource($subResource, $range)) {
                    $records = array_merge($records, $this->recordsExtractor->extractRecords($subResource));
                }
            }
        } else {
            $records = $this->recordsExtractor->extractRecords($responseContent);
        }

        return $records;
    }
}
