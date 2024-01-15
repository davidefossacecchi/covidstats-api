<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Records\Contracts\RecordInterface;

trait IsRecordSource
{
    protected string $recordClass;

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

    public function isDataTypeSource(DataType $type): bool
    {
        return call_user_func($this->recordClass.'::getDataType') === $type;
    }
}
