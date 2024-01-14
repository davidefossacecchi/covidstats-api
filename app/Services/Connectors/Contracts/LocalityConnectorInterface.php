<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\LocalityRecord;

interface LocalityConnectorInterface
{
    public function getLocalityId(LocalityTypes $type, string $name, int $externalId = null): int;

    public function getLocalityRecordId(LocalityRecord $localityRecord): int;

    public function getLocalities(LocalityTypes $type): array;
}
