<?php

namespace App\Console\Commands;

use App\Services\Connectors\Contracts\DataTypes;
use App\Services\Fetchers\Contracts\FetcherInterface;
use http\Exception\InvalidArgumentException;
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
    public function __construct(FetcherInterface ...$fetchers)
    {
        parent::__construct();
        $this->fetchers = $fetchers;
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
            }, DataTypes::cases());
        }

        if (false == empty($exclude)) {
            $ee = array_map('trim', explode(',', $exclude));
            $tt = array_diff($tt, $ee);
        }

        /** @var DataTypes[] $types */
        $types = $this->convertToDataType($tt);

        if (false == $refresh && false == empty($from)) {
            $dt = \DateTime::createFromFormat('Y-m-d', $from);
            if (false == $dt) {
                $this->error("from date must be in Y-m-d format");
                return 1;
            }

            $startDate = $dt->format('Y-m-d');
        }

        $this->info("Fetching data for ".implode(', ', $tt));

        foreach ($types as $type) {
            try {

                $msg = empty($fromDate)
                    ? "Fetching data for $type->name starting from the beginning"
                    : "Fetching data for $type->name starting from $fromDate";

                $this->info($msg.', wait!');
                Log::info($msg);

                $fetcher = $this->getFetcherForDataType($type);
                dd($fetcher);

            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
    }

    private function convertToDataType(array $stringTypes): array
    {
        $types = [];

        foreach ($stringTypes as $stringType) {
            $type = DataTypes::tryFrom($stringType);
            if(empty($type)) {
                throw new InvalidArgumentException("$stringType type does not exists");
            }
            $types[] = $type;
        }
        return $types;
    }

    private function getFetcherForDataType(DataTypes $type): FetcherInterface
    {

        foreach ($this->fetchers as $fetcher) {
            if ($fetcher->fetchDataType($type)) {
                return $fetcher;
            }
        }

        throw new \InvalidArgumentException('Fetcher for data type '.$type->value.' does not exists');
    }
}
