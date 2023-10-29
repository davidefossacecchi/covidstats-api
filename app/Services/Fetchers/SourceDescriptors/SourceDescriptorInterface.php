<?php

namespace App\Services\Fetchers\SourceDescriptors;

/**
 * Describes the resource
 */
interface SourceDescriptorInterface
{
    public function getResourceUrl(): string;

    public function getRecordClass(): string;
}
