<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataType;

/**
 * Describes the resource
 */
interface SourceDescriptorInterface
{
    public function getResourceUrl(): string;

    public function getRecordClass(): string;

    public function getResourceToExtract($resourceDescription): mixed;

    public function isDataTypeSource(DataType $type): bool;
}
