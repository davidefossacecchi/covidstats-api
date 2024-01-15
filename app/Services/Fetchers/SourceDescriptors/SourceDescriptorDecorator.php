<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Fetchers\Contracts\SourceDescriptorInterface;
use App\Services\Fetchers\Contracts\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;

/**
 * A decorator to join source descriptor and list descriptor to use them as a unique entity
 */
class SourceDescriptorDecorator implements SourceDescriptorInterface, SourceListDescriptorInterface
{
    public function __construct(private readonly SourceDescriptorInterface $source, private readonly SourceListDescriptorInterface $listDescriptor)
    {
    }

    /**
     * @inheritDoc
     */
    public function getResourceUrl(): string
    {
        return $this->source->getResourceUrl();
    }

    /**
     * @inheritDoc
     */
    public function getRecordClass(): string
    {
        return $this->source->getRecordClass();
    }

    /**
     * @inheritDoc
     */
    public function getResourceToExtract($resourceDescription): mixed
    {
        return $this->source->getResourceToExtract($resourceDescription);
    }

    /**
     * @inheritDoc
     */
    public function isValidSource(array|string $source, DateRange $range): bool
    {
        return $this->listDescriptor->isValidSource($source, $range);
    }

    /**
     * @inheritDoc
     */
    public function isDataTypeSource(DataType $type): bool
    {
        return $this->source->isDataTypeSource($type);
    }
}
