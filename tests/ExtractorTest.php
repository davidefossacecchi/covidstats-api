<?php
namespace Tests;
use App\Services\Fetchers\RecordsExtractors\CountriesApiExtractor;
use App\Services\Fetchers\RecordsExtractors\CsvExtractor;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ExtractorTest extends TestCase
{
    public function testCsvIsConvertedToAssociativeArray(): void
    {
        $data = "data,codice_regione,ricoverati\n2020-02-24T18:00:00,13,10\n2020-02-24T18:00:00,17,20";
        $expected = [
            [
                "data" =>'2020-02-24T18:00:00',
                "codice_regione" => "13",
                "ricoverati" => "10"
            ],
            [
                "data" =>'2020-02-24T18:00:00',
                "codice_regione" => "17",
                "ricoverati" => "20"
            ],
        ];
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($data);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);

        $client = $this->createMock(Client::class);
        $client->method('get')->willReturn($response);

        $extractor = new CsvExtractor($client);
        $records = $extractor->extractRecords('https://not.a-real-url.com');
        $this->assertEquals($expected, $records);
    }

    public function testApiRecordsAreConvertedCorrectly()
    {
        $data = [
            'Afghanistan' => [
                [
                    "date" => "2020-1-22",
                    "confirmed" => 0,
                    "deaths" => 0,
                    "recovered" => 0
                ],
                [
                    "date" => "2020-1-23",
                    "confirmed" => 0,
                    "deaths" => 0,
                    "recovered" => 0
                ]
            ],
            "Italy" => [
                [
                    "date" => "2020-1-22",
                    "confirmed" => 1,
                    "deaths" => 2,
                    "recovered" => 3
                ],
                [
                    "date" => "2020-1-23",
                    "confirmed" => 4,
                    "deaths" => 5,
                    "recovered" => 6
                ]
            ],
        ];

        $expected = [
            [
                "country" => "Afghanistan",
                "date" => "2020-1-22",
                "confirmed" => 0,
                "deaths" => 0,
                "recovered" => 0
            ],
            [
                "country" => "Afghanistan",
                "date" => "2020-1-23",
                "confirmed" => 0,
                "deaths" => 0,
                "recovered" => 0
            ],
            [
                "country" => "Italy",
                "date" => "2020-1-22",
                "confirmed" => 1,
                "deaths" => 2,
                "recovered" => 3
            ],
            [
                "country" => "Italy",
                "date" => "2020-1-23",
                "confirmed" => 4,
                "deaths" => 5,
                "recovered" => 6
            ]
        ];

        $extractor = new CountriesApiExtractor();
        $records = $extractor->extractRecords($data);
        $this->assertEquals($expected, $records);
    }
}
