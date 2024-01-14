<?php

namespace App\Console\Commands;

use App\Services\Connectors\Contracts\DataLoaderInterface;
use App\Services\Connectors\Contracts\DataPersisterInterface;
use App\Services\Connectors\Contracts\DataType;
use App\Services\Fetchers\Contracts\FetcherInterface;
use App\Services\Ranges\DateRange;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchStatisticsCommand extends Command
{
    protected $signature = 'stats:fetch
        {--from= : Defines the fetch min date in Y-m-d format}
        {--only= : Defines the only locality type to extract}
        {--exclude= : Excludes a locality type to extract}
        {--refresh : Start the extraction from the beginning}';

    protected $description = 'Fetch statistics from data sources';

    private array $fetchers;
    public function __construct(
        private readonly DataPersisterInterface $persister,
        private readonly DataLoaderInterface $dataLoader,
        FetcherInterface ...$fetchers
    )
    {
        parent::__construct();
        $this->fetchers = $fetchers;
        ini_set("memory_limit", "-1");
        set_time_limit(0);
    }

    public function handle()
    {
        $only      = $this->option('only');
        $exclude   = $this->option('exclude');
        $from      = $this->option('from');
        $refresh   = (bool) $this->option('refresh');
        $startDate = null;

        $tt = [];

        if (false == empty($only)) {
            $tt = array_map('trim', explode(',', $only));
        } else {
            $tt = array_map(function ($case) {
                return $case->value;
            }, DataType::cases());
        }

        if (false == empty($exclude)) {
            $ee = array_map('trim', explode(',', $exclude));
            $tt = array_diff($tt, $ee);
        }

        /** @var DataType[] $types */
        $types = $this->convertToDataType($tt);

        if (false == $refresh && false == empty($from)) {
            $startDate = \DateTime::createFromFormat('Y-m-d', $from);
            if (false == $startDate) {
                $this->error("from date must be in Y-m-d format");
                return 1;
            }
        }

        $this->info("Fetching data for ".implode(', ', $tt));

        foreach ($types as $type) {
            try {
                if (false == $refresh) {
                    $fromDate = $startDate ?: $this->dataLoader->getMaxDateForCollection($type);
                } else {
                    $fromDate = null;
                }
                $msg = empty($fromDate)
                    ? "Fetching data for $type->name starting from the beginning"
                    : "Fetching data for $type->name starting from ".$fromDate->format('Y-m-d');

                $dateRange = new DateRange($fromDate);

                $this->info($msg.', wait!');
                Log::info($msg);

                $fetcher = $this->getFetcherForDataType($type);
                $records = $fetcher->pull($dateRange);
                $this->info('Fetched '.count($records).' records for '.$type->name);
                $this->info('Persisting');
                $this->persister->persist($records);

            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
        $this->info('DONE');
    }

    private function convertToDataType(array $stringTypes): array
    {
        $types = [];

        foreach ($stringTypes as $stringType) {
            $type = DataType::tryFrom($stringType);
            if(empty($type)) {
                throw new \InvalidArgumentException("$stringType type does not exists");
            }
            $types[] = $type;
        }
        return $types;
    }

    private function getFetcherForDataType(DataType $type): FetcherInterface
    {

        foreach ($this->fetchers as $fetcher) {
            if ($fetcher->fetchDataType($type)) {
                return $fetcher;
            }
        }

        throw new \InvalidArgumentException('Fetcher for data type '.$type->value.' does not exists');
    }
}
