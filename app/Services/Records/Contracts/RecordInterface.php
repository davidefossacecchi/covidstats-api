<?php

namespace App\Services\Records\Contracts;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Records\LocalityRecord;

interface RecordInterface
{
    public function isValid(): bool;

    public function getDate(): \DateTimeInterface;

    public static function getDataType(): DataType;

    public function getLocality(): LocalityRecord;
}
