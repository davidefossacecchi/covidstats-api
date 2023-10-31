<?php

namespace App\Services\Records;

class RegionRecord implements RecordInterface
{
    private readonly string $locality;
    private readonly int $totalPositives;
    private readonly int $totalCases;
    private readonly int $icuPatients;

    private readonly int $hospPatients;
    private readonly int $homeIsolations;
    private readonly int $healed;

    private readonly int $deaths;

    private readonly int $swabs;

    private readonly ?\DateTimeInterface $date;

    public function __construct(array $row)
    {
        $this->locality = $row['denominazione_regione'] ?? '';
        $this->totalPositives = (int)($row['totale_positivi'] ?? 0);
        $this->totalCases = (int)($row['totale_casi'] ?? 0);
        $this->icuPatients = (int)($row['terapia_intensiva'] ?? 0);
        $this->hospPatients = (int)($row['terapia_ospedalizzati'] ?? 0);
        $this->homeIsolations = (int)($row['isolamento_domiciliare'] ?? 0);
        $this->healed = (int)($row['dimessi_guariti'] ?? 0);
        $this->deaths = (int)($row['deceduti'] ?? 0);
        $this->swabs = (int)($row['tamponi'] ?? 0);
        if (isset($row['data'])) {
            $this->date = \DateTime::createFromFormat('Y-m-d\TH:i:s', $row['data']);
        }
    }

    public function isValid(): bool
    {
        return false === empty($this->locality) && isset($this->date);
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getTotalPositives(): int
    {
        return $this->totalPositives;
    }

    public function getTotalCases(): int
    {
        return $this->totalCases;
    }

    public function getIcuPatients(): int
    {
        return $this->icuPatients;
    }

    public function getHospPatients(): int
    {
        return $this->hospPatients;
    }

    public function getHomeIsolations(): int
    {
        return $this->homeIsolations;
    }

    public function getHealed(): int
    {
        return $this->healed;
    }

    public function getDeaths(): int
    {
        return $this->deaths;
    }

    public function getSwabs(): int
    {
        return $this->swabs;
    }
}
