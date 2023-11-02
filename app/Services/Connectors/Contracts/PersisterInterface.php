<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\Contracts\RecordInterface;

interface PersisterInterface
{
    public function persist(RecordInterface $record): void;

    public function supports(RecordInterface $record): bool;
}
