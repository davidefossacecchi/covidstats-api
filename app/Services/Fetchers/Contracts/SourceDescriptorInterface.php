<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataType;

/**
 * Describes the resource
 */
interface SourceDescriptorInterface
{
    /**
     * Returns the resource url
     */
    public function getResourceUrl(): string;

    /**
     * Returns the specific RecordInterface implementation that feats the data
     */
    public function getRecordClass(): string;

    /**
     * Extract the unique resource identifier to extract from a specific source description
     */
    public function getResourceToExtract($resourceDescription): mixed;

    /**
     * Tells if the described resource is the source of a specific data type
     */
    public function isDataTypeSource(DataType $type): bool;
}
