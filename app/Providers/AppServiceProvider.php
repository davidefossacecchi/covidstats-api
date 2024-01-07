<?php

namespace App\Providers;

use App\Console\Commands\FetchStatisticsCommand;
use App\Services\Connectors\Contracts\DataPersisterInterface;
use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\PersistingItemTransformerInterface;
use App\Services\Connectors\LocalityDbConnector;
use App\Services\Connectors\PersistingItemTransformers\PersistingCountryDataTransformer;
use App\Services\Connectors\PersistingItemTransformers\PersistingProvinceDataTransformer;
use App\Services\Connectors\PersistingItemTransformers\PersistingRegionDataTransformer;
use App\Services\Connectors\TimepointsDbConnector;
use App\Services\Fetchers\ApiFetcher;
use App\Services\Fetchers\Contracts\FetcherInterface;
use App\Services\Fetchers\GithubFetcher;
use App\Services\Fetchers\SourceDescriptors\ApiSourceDescriptor;
use App\Services\Fetchers\SourceDescriptors\GithubSourceDescriptor;
use App\Services\Fetchers\SourceDescriptors\NullSourceDescriptor;
use App\Services\Fetchers\SourceDescriptors\SourceDescriptorDecorator;
use GuzzleHttp\Client;
use Laravel\Lumen\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $covidstats = config('covidstats');

        $this->app->bind(LocalityConnectorInterface::class, LocalityDbConnector::class);
        $this->app->bind(DataPersisterInterface::class, TimepointsDbConnector::class);

        $this->app->when(TimepointsDbConnector::class)
            ->needs(PersistingItemTransformerInterface::class)
            ->give([
                PersistingProvinceDataTransformer::class,
                PersistingRegionDataTransformer::class,
                PersistingCountryDataTransformer::class
            ]);

        $fetcherNames = [];
        foreach ($covidstats as $dataDescriptor) {
            $name = 'fetcher.'.$dataDescriptor['data_type']->value;
            $fetcherNames[] = $name;
            $this->app->bind($name, function (Application $app) use ($dataDescriptor) {
                $fetcher = $dataDescriptor['fetcher'];
                $extractor = $app->make($dataDescriptor['extractor']);
                $list = $dataDescriptor['list'] ?? null;
                $sourceDescriptor = new NullSourceDescriptor();
                $recordClass = $dataDescriptor['record_type'];
                switch($fetcher) {
                    case GithubFetcher::class:
                        $repository = $dataDescriptor['repository'];
                        $path = $dataDescriptor['path'];
                        $sourceDescriptor = new GithubSourceDescriptor($repository, $path, $recordClass);
                        break;
                    case ApiFetcher::class:
                        $url = $dataDescriptor['url'];
                        $sourceDescriptor = new ApiSourceDescriptor($url, $recordClass);
                }

                if (isset($list)) {
                    $listDescriptor = $app->make($list['descriptor'], $list['arguments']);
                    $sourceDescriptor = new SourceDescriptorDecorator($sourceDescriptor, $listDescriptor);
                }

                /** @todo maybe can be replaced with only one class with different source descriptions */
                return match ($fetcher) {
                    GithubFetcher::class => new GithubFetcher($app->make(Client::class), $sourceDescriptor, $extractor),
                    ApiFetcher::class => new ApiFetcher($app->make(Client::class), $sourceDescriptor, $extractor)
                };

            });
        }

        $this->app->tag($fetcherNames, FetcherInterface::class);

        /** @todo needs to be replaced with an implementation of ArrayAccess to let the command get the record type to access only*/
        $this->app->when(FetchStatisticsCommand::class)
            ->needs(FetcherInterface::class)
            ->giveTagged(FetcherInterface::class);
    }
}
