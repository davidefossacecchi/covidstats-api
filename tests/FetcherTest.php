<?php
namespace Tests;
use App\Services\Fetchers\GithubFetcher;
use App\Services\Fetchers\SourceDescriptors\SourceDescriptorInterface;
use App\Services\Ranges\DateRange;
use App\Services\Records\RegionRecord;

class FetcherTest extends TestCase
{
    public function testInvalidRecordsAreStripped()
    {
        $range = new DateRange(null, new \DateTime());
        $data = [
            // invalid, there is no locality
            ['data' => '2020-02-24T18:00:00'],
            // invalid, there is no date
            ['denominazione_regione' => 'Abruzzo'],
            // date is out of range
            ['denominazione_regione' => 'Abruzzo', 'data' => '2222-02-24T18:00:00'],
            // valid
            ['denominazione_regione' => 'Emilia-Romagna', 'data' => '2020-02-24T18:00:00'],
        ];
        $fetcher = $this->getMockBuilder(GithubFetcher::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getSourceDescriptor', 'fetch'])
            ->getMock();

        $source = $this->createMock(SourceDescriptorInterface::class);
        $source->method('getRecordClass')->willReturn(RegionRecord::class);
        $fetcher->method('getSourceDescriptor')->willReturn($source);
        $fetcher->method('fetch')->willReturn($data);

        $iterator = $fetcher->pull($range);
        $this->assertEquals(1, count($iterator));

        /** @var RegionRecord $record */
        foreach ($iterator as $record) {
            $this->assertEquals('Emilia-Romagna', $record->getLocality());
        }
    }
}
