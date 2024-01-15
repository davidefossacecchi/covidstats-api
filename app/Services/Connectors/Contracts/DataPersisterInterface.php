<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\Contracts\RecordInterface;
use App\Services\Records\RecordIterator;

interface DataPersisterInterface
{
    /**
     * Persists records in the persistent collection
     */
    public function persist(\Iterator $records): void;
}
