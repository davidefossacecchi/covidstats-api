<?php

namespace App\Services\Records;

interface RecordInterface
{
    public function isValid(): bool;

    public function getDate(): \DateTimeInterface;
}
