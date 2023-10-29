<?php

namespace App\Services\Fetchers\SourceDescriptors;

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


}
