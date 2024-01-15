<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\Contracts\RecordInterface;

interface PersistingItemTransformerInterface
{
    /**
     * Tells if a transformer supports a specific implementation of a record interface
     */
    public function supports(RecordInterface $record): bool;

    /**
     * Returns the record data type
     */
    public function getDataType(): DataType;

    /**
     * Returns the set of unique keys for the collection
     */
    public function getCollectionUniqueKeys(): array;

    /**
     * Returns the transformed row
     */
    public function getRow(RecordInterface $record): array;
}
