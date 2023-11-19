<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\Contracts\RecordInterface;

interface PersistingItemTransformerInterface
{
    public function supports(RecordInterface $record): bool;

    public function getDataType(): DataTypes;

    public function getCollectionUniqueKeys(): array;

    public function getRow(RecordInterface $record): array;
}
