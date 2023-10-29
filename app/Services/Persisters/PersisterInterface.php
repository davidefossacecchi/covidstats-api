<?php

namespace App\Services\Persisters;

use App\Services\Records\RecordInterface;

interface PersisterInterface
{
    public function persist(RecordInterface $record): void;

    public function supports(RecordInterface $record): bool;
}
