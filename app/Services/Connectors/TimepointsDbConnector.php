<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\DataLoaderInterface;
use App\Services\Connectors\Contracts\DataPersisterInterface;
use App\Services\Connectors\Contracts\DataType;
use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityType;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Connectors\Exceptions\NotFoundLocalityException;
use App\Services\Ranges\DateRange;
use Illuminate\Support\Facades\DB;

class TimepointsDbConnector implements DataPersisterInterface, DataLoaderInterface
{
    private array $itemTransformers;
    public function __construct(private readonly LocalityConnectorInterface $localityConnector, PersistingItemTransformerInterface ...$itemTransformers)
    {
        $this->itemTransformers = $itemTransformers;
    }

    /**
     * @inheritDoc
     */
    public function persist(\Iterator $records): void
    {
        $map = [];
        foreach ($records as $record) {
            $found = false;
            foreach ($this->itemTransformers as $transformer) {
                if ($transformer->supports($record)) {
                    $collectionName = $transformer->getDataType()->value;
                    if (empty($map[$collectionName])) {
                        $map[$collectionName] = [
                            'unique_keys' => $transformer->getCollectionUniqueKeys(),
                            'rows' => []
                        ];
                    }
                    $map[$collectionName]['rows'][] = $transformer->getRow($record);
                    if (count($map[$collectionName]['rows']) >= 50) {
                        $this->persistRows($collectionName, $map[$collectionName]['unique_keys'], $map[$collectionName]['rows']);
                        $map[$collectionName]['rows'] = [];
                    }
                    $found = true;
                    break;
                }
            }
        }

        if (false === $found) {
            throw new \InvalidArgumentException('Persisting item transformer for record '.get_class($record). 'does not exixts');
        }

        // final flush
        foreach ($map as $collectionName => $collectionData) {
            $this->persistRows($collectionName, $collectionData['unique_keys'], $collectionData['rows']);
        }
    }

    /**
     * @inheritDoc
     */
    public function load(LocalityType $type, int $localityId, DateRange $range): array
    {
        $locality = $this->localityConnector->getLocality($localityId);
        if (empty($locality) || $type->value !== (int) $locality['type']) {
            throw new NotFoundLocalityException('Locality with id '.$localityId.' cannot be found');
        }

        $collectionKey = match ((int) $locality['type']) {
            LocalityType::COUNTRY->value => DataType::COUNTRY->value,
            LocalityType::REGION->value => DataType::REGION->value,
            LocalityType::PROVINCE->value => DataType::PROVINCE->value
        };

        $qb = DB::table($collectionKey)
            ->where('locality_id', $localityId)
            ->orderBy('date');

        $from = $range->getFrom();
        $to = $range->getTo();

        if (isset($from)) {
            $qb->where('date', '>=', $from->format('Y-m-d'));
        }

        if (isset($to)) {
            $qb->where('date', '<=', $to->format('Y-m-d'));
        }

        return $qb->get()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getMaxDateForCollection(DataType $types): ?\DateTimeInterface
    {
        $maxDate = DB::table($types->value)
            ->select(DB::raw('MAX(date) as max_date'))
            ->value('max_date');

        return isset($maxDate)
            ? \DateTime::createFromFormat('Y-m-d', $maxDate)
            : null;
    }


    private function persistRows(string $table, array $uniqueKey, array $rows): void
    {
        if (count($rows) > 0) {
            DB::table($table)
                ->upsert(
                    $rows,
                    $uniqueKey,
                    array_keys($rows[0])
                );
        }
    }
}
