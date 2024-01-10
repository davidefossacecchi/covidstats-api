<?php

namespace App\Services\Fetchers\Contracts;

use App\Services\Connectors\Contracts\DataTypes;

/**
 * Describes the resource
 */
interface SourceDescriptorInterface
{
    public function getResourceUrl(): string;

    public function getRecordClass(): string;

    public function getResourceToExtract($resourceDescription): mixed;

    public function isDataTypeSource(DataTypes $type): bool;
}
