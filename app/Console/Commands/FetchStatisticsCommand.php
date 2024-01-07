<?php

namespace App\Console\Commands;

use App\Services\Fetchers\Contracts\FetcherInterface;
use Illuminate\Console\Command;

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
        dd($this->fetchers);
    }
}
