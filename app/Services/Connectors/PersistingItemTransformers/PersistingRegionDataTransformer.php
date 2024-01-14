<?php

namespace App\Services\Connectors\PersistingItemTransformers;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityType;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Records\Contracts\RecordInterface;
use App\Services\Records\RegionRecord;

class PersistingRegionDataTransformer implements PersistingItemTransformerInterface
{
    public function __construct(public readonly LocalityConnectorInterface $localityConnector)
    {
    }

    public function supports(RecordInterface $record): bool
    {
        return $record instanceof RegionRecord;
    }

    public function getDataType(): DataType
    {
        return DataType::REGION;
    }


    public function getCollectionUniqueKeys(): array
    {
        return ['locality_id', 'date'];
    }

    public function getRow(RecordInterface $record): array
    {
        /** @var RegionRecord $record */
        $localityId = $this->localityConnector->getLocalityRecordId($record->getLocality());
        return [
            'locality_id' => $localityId,
            'icu_patients' => $record->getIcuPatients(),
            'hosp_patients' => $record->getHospPatients(),
            'home_isolation' => $record->getHomeIsolations(),
            'total_positives' => $record->getTotalPositives(),
            'healed' => $record->getHealed(),
            'deaths' => $record->getDeaths(),
            'total_cases' => $record->getTotalCases(),
            'date' => $record->getDate(),
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime()
        ];
    }

}
