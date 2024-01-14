<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\LocalityRecord;

interface LocalityConnectorInterface
{
    public function getLocalityId(LocalityType $type, string $name, int $externalId = null): int;

    public function getLocalityRecordId(LocalityRecord $localityRecord): int;

    public function getLocalities(LocalityType $type): array;

    public function getLocality(int $id): ?array;
}
