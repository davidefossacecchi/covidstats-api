<?php

namespace App\Services\Records;

use App\Services\Connectors\Contracts\LocalityTypes;
use App\Services\Connectors\Contracts\DataType;
use App\Services\Records\Contracts\RecordInterface;

class ProvinceRecord implements RecordInterface
{
    private readonly string $locality;

    private readonly int $localityCode;

    private readonly int $totalCases;

    private readonly ?\DateTimeInterface $date;

    public function __construct(array $row)
    {
        $this->locality = $row['denominazione_provincia'] ?? '';
        $this->localityCode = $row['codice_provincia'] ?? 0;
        $this->totalCases = (int)($row['totale_casi'] ?? 0);
        if (isset($row['data'])) {
            $this->date = \DateTime::createFromFormat('Y-m-d\TH:i:s', $row['data']);
        }
    }

    public function isValid(): bool
    {
        $invalidNames = ['In fase di definizione/aggiornamento', 'Fuori Regione / Provincia Autonoma'];
        return false === empty($this->locality) && false === in_array($this->locality, $invalidNames) && isset($this->date) && false === empty($this->localityCode);
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getLocality(): LocalityRecord
    {
        return new LocalityRecord(LocalityTypes::PROVINCE, $this->locality, $this->localityCode);
    }

    public function getTotalCases(): int
    {
        return $this->totalCases;
    }

    public static function getDataType(): DataType
    {
        return DataType::PROVINCE;
    }
}
