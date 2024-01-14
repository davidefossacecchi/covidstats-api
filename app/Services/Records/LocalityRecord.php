<?php

namespace App\Services\Records;

use App\Services\Connectors\Contracts\LocalityType;

class LocalityRecord
{
    public function __construct(
        private readonly LocalityType $type,
        private readonly string       $name,
        private readonly ?int         $externalId = null
    )
    {

    }

    public function getType(): LocalityType
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }
}
