<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Fetchers\Contracts\SourceDescriptorInterface;

class ApiSourceDescriptor implements SourceDescriptorInterface
{
    use IsRecordSource;
    public function __construct(private readonly string $url, string $recordClass)
    {
        $this->setRecordClass($recordClass);
    }

    public function getResourceUrl(): string
    {
        return $this->url;
    }

    public function getResourceToExtract($resourceDescription): mixed
    {
        return $resourceDescription;
    }
}
