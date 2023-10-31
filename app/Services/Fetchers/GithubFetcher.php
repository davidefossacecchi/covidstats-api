<?php

namespace App\Services\Fetchers;
use App\Services\Fetchers\RecordsExtractors\RecordsExtractorInterface;
use App\Services\Fetchers\SourceDescriptors\SourceDescriptorInterface;
use App\Services\Fetchers\SourceDescriptors\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;
use GuzzleHttp\Client;
class GithubFetcher implements FetcherInterface
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
            foreach ($responseContent as $file) {
                $fileUrl = $file['download_url'];
                if ($this->source->isValidSource($fileUrl)) {
                    $records = array_merge($records, $this->recordsExtractor->extractRecords($fileUrl));
                }
            }
        } else {
            $fileUrl = $responseContent['download_url'];
            $records = $this->recordsExtractor->extractRecords($fileUrl);
        }

        return $records;
    }
}
