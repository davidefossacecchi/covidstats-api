<?php

namespace App\Services\Connectors\PersistingItemTransformers;

use App\Services\Connectors\Contracts\DataType;
use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityType;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Records\Contracts\RecordInterface;
use App\Services\Records\ProvinceRecord;
use App\Services\Records\RegionRecord;

class PersistingProvinceDataTransformer implements PersistingItemTransformerInterface
{
    public function __construct(public readonly LocalityConnectorInterface $localityConnector)
    {
    }

    /**
     * @inheritDoc
     */
    public function supports(RecordInterface $record): bool
    {
        return $record instanceof ProvinceRecord;
    }

    /**
     * @inheritDoc
     */
    public function getDataType(): DataType
    {
        return DataType::PROVINCE;
    }

    /**
     * @inheritDoc
     */
    public function getCollectionUniqueKeys(): array
    {
        return ['locality_id', 'date'];
    }

    /**
     * @inheritDoc
     */
    public function getRow(RecordInterface $record): array
    {
        /** @var ProvinceRecord $record */
        $localityId = $this->localityConnector->getLocalityRecordId($record->getLocality());
        return [
            'locality_id' => $localityId,
            'total_cases' => $record->getTotalCases(),
            'date' => $record->getDate(),
            'updated_at' => new \DateTime(),
            'created_at' => new \DateTime()
        ];
    }

}
