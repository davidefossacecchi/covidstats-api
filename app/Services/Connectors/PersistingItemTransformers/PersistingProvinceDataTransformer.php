<?php

namespace App\Services\Connectors\PersistingItemTransformers;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityTypes;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Records\Contracts\RecordInterface;
use App\Services\Records\ProvinceRecord;
use App\Services\Records\RegionRecord;

class PersistingProvinceDataTransformer implements PersistingItemTransformerInterface
{
    public function __construct(public readonly LocalityConnectorInterface $localityConnector)
    {
    }

    public function supports(RecordInterface $record): bool
    {
        return $record instanceof ProvinceRecord;
    }

    public function getDataType(): DataTypes
    {
        return DataTypes::PROVINCE;
    }


    public function getCollectionUniqueKeys(): array
    {
        return ['locality_id', 'date'];
    }

    public function getRow(RecordInterface $record): array
    {
        /** @var ProvinceRecord $record */
        $localityId = $this->localityConnector->getLocalityId(LocalityTypes::PROVINCE, $record->getLocality());
        return [
            'locality_id' => $localityId,
            'total_cases' => $record->getTotalCases(),
            'date' => $record->getDate(),
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime()
        ];
    }

}
