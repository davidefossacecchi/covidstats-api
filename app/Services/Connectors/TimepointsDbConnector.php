<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\DataPersisterInterface;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Records\RecordIterator;
use Illuminate\Support\Facades\DB;

class TimepointsDbConnector implements DataPersisterInterface
{
    private array $itemTransformers;
    public function __construct(PersistingItemTransformerInterface ...$itemTransformers)
    {
        $this->itemTransformers = $itemTransformers;
    }

    public function persist(RecordIterator $records): void
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
