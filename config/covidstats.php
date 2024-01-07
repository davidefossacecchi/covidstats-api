<?php

return [
    [
        'data_type' => \App\Services\Connectors\Contracts\DataTypes::PROVINCE,
        'record_type' => \App\Services\Records\ProvinceRecord::class,
        'fetcher' => \App\Services\Fetchers\GithubFetcher::class,
        'repository' => 'pcm-dpc/COVID-19',
        'path' => 'dati-province',
        'extractor' => \App\Services\Fetchers\RecordsExtractors\CsvExtractor::class,
        'list' => [
            'descriptor' => \App\Services\Fetchers\SourceDescriptors\PcmDpcListDescriptor::class,
            'arguments' => ['filePrefix' => 'dpc-covid19-ita-province-']
        ]
    ],
    [
        'data_type' => \App\Services\Connectors\Contracts\DataTypes::REGION,
        'record_type' => \App\Services\Records\RegionRecord::class,
        'fetcher' => \App\Services\Fetchers\GithubFetcher::class,
        'repository' => 'pcm-dpc/COVID-19',
        'path' => 'dati-regioni',
        'extractor' => \App\Services\Fetchers\RecordsExtractors\CsvExtractor::class,
        'list' => [
            'descriptor' => \App\Services\Fetchers\SourceDescriptors\PcmDpcListDescriptor::class,
            'arguments' => ['filePrefix' => 'dpc-covid19-ita-regioni-']
        ]
    ],
    [
        'data_type' => \App\Services\Connectors\Contracts\DataTypes::COUNTRY,
        'record_type' => \App\Services\Records\CountryRecord::class,
        'fetcher' => \App\Services\Fetchers\ApiFetcher::class,
        'url' => 'https://pomber.github.io/covid19/timeseries.json',
        'extractor' => \App\Services\Fetchers\RecordsExtractors\CountriesApiExtractor::class,
    ]
];
