<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\Contracts\RecordInterface;
use App\Services\Records\RecordIterator;

interface DataPersisterInterface
{
    public function persist(RecordIterator $records): void;
}
