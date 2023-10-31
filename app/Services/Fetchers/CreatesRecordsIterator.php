<?php

namespace App\Services\Fetchers;

use App\Services\Fetchers\SourceDescriptors\SourceDescriptorInterface;
use App\Services\Ranges\DateRange;
use App\Services\Records\DateRangeFilter;
use App\Services\Records\RecordIterator;
use App\Services\Records\ValidFilter;

trait CreatesRecordsIterator
{
    abstract protected function fetch(DateRange $range): array;
    abstract protected function getSourceDescriptor(): SourceDescriptorInterface;

    public function pull(DateRange $range): \Iterator
    {
        $records = $this->fetch($range);

        $recordClass = $this->getSourceDescriptor()->getRecordClass();

        $iterator = new RecordIterator($records, $recordClass);
        return new DateRangeFilter(new ValidFilter($iterator), $range);
    }
}
