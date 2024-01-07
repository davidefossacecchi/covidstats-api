<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Fetchers\Contracts\SourceDescriptorInterface;

class NullSourceDescriptor implements SourceDescriptorInterface
{
    public function getResourceUrl(): string
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }

    public function getRecordClass(): string
    {
        throw new \BadMethodCallException('Source descriptor not set');
    }

}
