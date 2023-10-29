<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Records\RecordInterface;

trait IsRecordSource
{
    protected readonly string $recordClass;

    protected function setRecordClass(string $recordClass): void
    {
        if (false === is_subclass_of($recordClass, RecordInterface::class)) {
            throw new \InvalidArgumentException('Record class has to be an implementation of '.RecordInterface::class);
        }
        $this->recordClass = $recordClass;
    }

    public function getRecordClass(): string
    {
        return $this->recordClass;
    }
}
