<?php

namespace App\Services\Connectors\Contracts;

interface LocalityConnectorInterface
{
    public function getLocalityId(LocalityTypes $type, string $name, int $externalId = null): int;

    public function getLocalities(LocalityTypes $type): array;
}
