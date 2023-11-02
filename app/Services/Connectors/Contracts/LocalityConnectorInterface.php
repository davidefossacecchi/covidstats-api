<?php

namespace App\Services\Connectors\Contracts;

interface LocalityConnectorInterface
{
    public function getLocality(string $type, string $name, int $externalId = null): array;

    public function getLocalities(string $type): array;
}
