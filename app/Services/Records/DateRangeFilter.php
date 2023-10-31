<?php

namespace App\Services\Records;

use App\Services\Ranges\DateRange;
use Iterator;

class DateRangeFilter extends \FilterIterator implements \Countable
{
    public function __construct(Iterator $iterator, private readonly DateRange $range)
    {
        parent::__construct($iterator);
    }

    public function count(): int
    {
        return count(iterator_to_array($this));
    }

    public function accept(): bool
    {
        $record = parent::current();
        if ($record instanceof RecordInterface) {
            return $this->range->includes($record->getDate());
        }

        throw new \InvalidArgumentException(self::class.' is appliable only to iterator of implementation of '.RecordInterface::class);
    }

}
