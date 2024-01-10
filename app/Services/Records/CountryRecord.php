<?php

namespace App\Services\Records;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Records\Contracts\RecordInterface;

class CountryRecord implements RecordInterface
{
    private readonly string $locality;

    private readonly \DateTimeInterface $date;

    private readonly int $healed;

    private readonly int $deaths;

    private readonly int $totalCases;
    public function __construct(array $row)
    {
        $this->locality = $row['country'];
        $this->healed = (int) $row['recovered'];
        $this->deaths = (int) $row['deaths'];
        $this->totalCases = (int) $row['confirmed'];
        $this->date = \DateTime::createFromFormat('Y-m-d H:i:s', $row['date'].' 00:00:00');
    }

    public function isValid(): bool
    {
        return true;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getHealed(): int
    {
        return $this->healed;
    }

    public function getDeaths(): int
    {
        return $this->deaths;
    }

    public function getTotalCases(): int
    {
        return $this->totalCases;
    }

    public static function getDataType(): DataTypes
    {
        return DataTypes::COUNTRY;
    }
}
