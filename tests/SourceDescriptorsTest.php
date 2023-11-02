<?php
namespace Tests;
use App\Services\Fetchers\SourceDescriptors\PcmDpcListDescriptor;
use App\Services\Ranges\DateRange;

class SourceDescriptorsTest extends TestCase
{
    private PcmDpcListDescriptor $listDescriptor;
    private DateRange $range;
    protected function setUp(): void
    {
        $this->listDescriptor = new PcmDpcListDescriptor('dpc-covid19-ita-regioni-');
        $this->range = new DateRange(\DateTime::createFromFormat('Y-m-d H:i:s', '2019-01-01 00:00:00'), new \DateTime());
    }

    public function testInvalidFilenameIsNotAccepted()
    {
        $invalidNames = ['just-an-invalid-file', 'dpc-covid19-ita-regioni-22224.csv'];
        foreach ($invalidNames as $invalidName) {
            $isValid = $this->listDescriptor->isValidSource($invalidName, $this->range);
            $this->assertFalse($isValid);
        }
    }

    public function testOutOfRangeDatesAreInvalid()
    {
        $invalidNames = ['dpc-covid19-ita-regioni-20180101.csv', 'dpc-covid19-ita-regioni-21000101.csv'];
        foreach ($invalidNames as $invalidName) {
            $isValid = $this->listDescriptor->isValidSource($invalidName, $this->range);
            $this->assertFalse($isValid);
        }
    }

    public function testValidNamesInRangeAreValid()
    {
        $lastDate = (new \DateTime())->sub(new \DateInterval('P1D'))->format('Ymd');

        $invalidNames = ['dpc-covid19-ita-regioni-20190101.csv', 'dpc-covid19-ita-regioni-'.$lastDate.'.csv'];
        foreach ($invalidNames as $invalidName) {
            $isValid = $this->listDescriptor->isValidSource($invalidName, $this->range);
            $this->assertTrue($isValid);
        }
    }
}
