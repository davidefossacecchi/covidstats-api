<?php
namespace Tests;
class RecordsTest extends TestCase
{
    public function testRegionRecordsWithoutLocalityAreInvalid()
    {
        $record = new \App\Services\Records\RegionRecord(['data' => '2020-02-24T18:00:00']);
        $this->assertFalse($record->isValid());
    }

    public function testRegionRecordsWithoutValuesAreAllZero()
    {
        $record = new \App\Services\Records\RegionRecord(['data' => '2020-02-24T18:00:00', 'denominazione_regione' => 'Abruzzo']);
        $this->assertEquals(0, $record->getTotalPositives());
        $this->assertEquals(0, $record->getTotalCases());
        $this->assertEquals(0, $record->getIcuPatients());
        $this->assertEquals(0, $record->getHospPatients());
        $this->assertEquals(0, $record->getHomeIsolations());
        $this->assertEquals(0, $record->getHealed());
        $this->assertEquals(0, $record->getDeaths());
        $this->assertEquals(0, $record->getSwabs());
    }

    public function testProvinceRecordsWithoutLocalityAreInvalid()
    {
        $record = new \App\Services\Records\ProvinceRecord(['data' => '2020-02-24T18:00:00']);
        $this->assertFalse($record->isValid());
    }

    public function testProvinceRecordsWithoutValuesAreAllZero()
    {
        $record = new \App\Services\Records\ProvinceRecord(['data' => '2020-02-24T18:00:00', 'denominazione_provincia' => 'Abruzzo']);
        $this->assertEquals(0, $record->getTotalCases());
    }

    public function testProvinceWithInvalidNamesAreInvalid()
    {
        $invalidNames = ['In fase di definizione/aggiornamento', 'Fuori Regione / Provincia Autonoma'];
        $record = new \App\Services\Records\ProvinceRecord(['data' => '2020-02-24T18:00:00', 'denominazione_provincia' => $invalidNames[0]]);
        $this->assertFalse($record->isValid());

        $record = new \App\Services\Records\ProvinceRecord(['data' => '2020-02-24T18:00:00', 'denominazione_provincia' => $invalidNames[1]]);
        $this->assertFalse($record->isValid());
    }
}
