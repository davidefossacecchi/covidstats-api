<?php

namespace App\Services\Connectors;

use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityType;
use App\Services\Records\LocalityRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LocalityDbConnector implements LocalityConnectorInterface
{
    private const TABLE = 'locality';

    private static array $cache = [];

    /**
     * @inheritDoc
     */
    public function getLocalityRecordId(LocalityRecord $localityRecord): int
    {
        return $this->getLocalityId($localityRecord->getType(), $localityRecord->getName(), $localityRecord->getExternalId());
    }

    /**
     * @inheritDoc
     */
    public function getLocalityId(LocalityType $type, string $name, int $externalId = null): int
    {
        $localities = $this->getLocalityCacheByType($type);
        if (isset($externalId)) {
            $persisted = $localities->firstWhere('external_id', $externalId);
        } else {
            $persisted = $localities->firstWhere('name', $name);
        }

        if (empty($persisted)) {
            $data = compact('name');
            if (isset($externalId)) {
                $data['external_id'] = $externalId;
            }
            $persisted = (array) $this->persistLocality($type, $data);
        }

        return (int) $persisted['id'];
    }

    /**
     * @inheritDoc
     */
    public function getLocalities(LocalityType $type): array
    {
        return $this->getLocalityCacheByType($type)->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getLocality(int $id): ?array
    {
        $locality = DB::table(self::TABLE)
            ->where('id', $id)
            ->first();

        return isset($locality)
            ? (array) $locality
            : null;
    }


    /**
     * Returns the cached list of localities by locality type
     */
    protected function getLocalityCacheByType(LocalityType $type): Collection
    {
        if(false == isset(self::$cache[$type->value])) {
            $localities = DB::table(self::TABLE)
                ->select(['id', 'external_id', 'name'])
                ->where('type', $type->value)
                ->orderBy('name')
                ->get();

            self::$cache[$type->value] = $localities->map(fn ($item) => (array) $item);
        }

        return self::$cache[$type->value];
    }

    /**
     * Writes a locality data to db and returns the locality id
     */
    protected function persistLocality(LocalityType $type, array $data): array
    {
        $locality = array_merge($data, [
            'type'        => $type->value,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        $id = DB::table(self::TABLE)
            ->insertGetId($locality);
        $locality['id'] = $id;

        self::$cache[$type->value]->push($locality);
        return $locality;
    }

}
