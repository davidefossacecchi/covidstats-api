<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Fetchers\Contracts\SourceDescriptorInterface;

/**
 * Placeholder source desciptor for when the real source descriptor is not instantiated yet
 */
class NullSourceDescriptor implements SourceDescriptorInterface
{
    /**
     * @inheritDoc
     */
    public function getResourceUrl(): string
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }

    /**
     * @inheritDoc
     */
    public function getRecordClass(): string
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }

    /**
     * @inheritDoc
     */
    public function getResourceToExtract($resourceDescription): mixed
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }

    /**
     * @inheritDoc
     */
    public function isDataTypeSource(DataType $type): bool
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }


}
