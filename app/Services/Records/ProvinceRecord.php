<?php

namespace App\Services\Records;

use App\Services\Records\Contracts\RecordInterface;

class ProvinceRecord implements RecordInterface
{
    private readonly string $locality;

    private readonly int $totalCases;

    private readonly ?\DateTimeInterface $date;

    public function __construct(array $row)
    {
        $this->locality = $row['denominazione_provincia'] ?? '';
        $this->totalCases = (int)($row['totale_casi'] ?? 0);
        if (isset($row['data'])) {
            $this->date = \DateTime::createFromFormat('Y-m-d\TH:i:s', $row['data']);
        }
    }

    public function isValid(): bool
    {
        $invalidNames = ['In fase di definizione/aggiornamento', 'Fuori Regione / Provincia Autonoma'];
        return false === empty($this->locality) && false === in_array($this->locality, $invalidNames) && isset($this->date);
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getTotalCases(): int
    {
        return $this->totalCases;
    }
}
