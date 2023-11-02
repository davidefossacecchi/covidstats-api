<?php

namespace App\Services\Records\Contracts;

interface RecordInterface
{
    public function isValid(): bool;

    public function getDate(): \DateTimeInterface;
}
