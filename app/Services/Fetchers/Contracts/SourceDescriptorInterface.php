<?php

namespace App\Services\Fetchers\Contracts;

/**
 * Describes the resource
 */
interface SourceDescriptorInterface
{
    public function getResourceUrl(): string;

    public function getRecordClass(): string;

    public function getResourceToExtract($resourceDescription): mixed;
}
