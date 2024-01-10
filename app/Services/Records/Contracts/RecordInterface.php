<?php

namespace App\Services\Records\Contracts;

use App\Services\Connectors\Contracts\DataTypes;

interface RecordInterface
{
    public function isValid(): bool;

    public function getDate(): \DateTimeInterface;

    public static function getDataType(): DataTypes;
}
