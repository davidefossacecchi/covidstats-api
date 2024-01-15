<?php

namespace App\Services\Fetchers;

use App\Services\Fetchers\Contracts\SourceDescriptorInterface;
use App\Services\Ranges\DateRange;
use App\Services\Records\DateRangeFilter;
use App\Services\Records\RecordIterator;
use App\Services\Records\ValidFilter;

trait CreatesRecordsIterator
{
    /**
     * Fetch data from the remote source
     */
    abstract protected function fetch(DateRange $range): array;


    abstract protected function getSourceDescriptor(): SourceDescriptorInterface;

    public function pull(DateRange $range): \Iterator & \Countable
    {
        $records = $this->fetch($range);

        $recordClass = $this->getSourceDescriptor()->getRecordClass();

        $iterator = new RecordIterator($records, $recordClass);
        return new DateRangeFilter(new ValidFilter($iterator), $range);
    }
}
