<?php

namespace App\Services\Records\Contracts;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Records\LocalityRecord;

interface RecordInterface
{
    public function isValid(): bool;

    public function getDate(): \DateTimeInterface;

    public static function getDataType(): DataTypes;

    public function getLocality(): LocalityRecord;
}
