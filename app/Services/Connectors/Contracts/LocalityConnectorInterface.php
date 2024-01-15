<?php

namespace App\Services\Connectors\Contracts;

use App\Services\Records\LocalityRecord;

interface LocalityConnectorInterface
{
    /**
     * Returns the locality id for a specific type, name and external id
     */
    public function getLocalityId(LocalityType $type, string $name, int $externalId = null): int;

    /**
     * Returns the ID for the locality record
     */
    public function getLocalityRecordId(LocalityRecord $localityRecord): int;

    /**
     * Returns all the locality data for a specific type
     */
    public function getLocalities(LocalityType $type): array;

    /**
     * Returns a locality by id or null if it is not found
     */
    public function getLocality(int $id): ?array;
}
