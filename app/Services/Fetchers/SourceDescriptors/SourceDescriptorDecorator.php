<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Fetchers\Contracts\SourceDescriptorInterface;
use App\Services\Fetchers\Contracts\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;

class SourceDescriptorDecorator implements SourceDescriptorInterface, SourceListDescriptorInterface
{
    public function __construct(private readonly SourceDescriptorInterface $source, private readonly SourceListDescriptorInterface $listDescriptor)
    {
    }

    public function getResourceUrl(): string
    {
        return $this->source->getResourceUrl();
    }

    public function getRecordClass(): string
    {
        return $this->source->getRecordClass();
    }

    public function getResourceToExtract($resourceDescription): mixed
    {
        return $this->source->getResourceToExtract($resourceDescription);
    }


    public function isValidSource(array|string $source, DateRange $range): bool
    {
        return $this->listDescriptor->isValidSource($source, $range);
    }

    public function isDataTypeSource(DataTypes $type): bool
    {
        return $this->source->isDataTypeSource($type);
    }
}
