<?php

namespace App\Services\Records;

use Iterator;

class ValidFilter extends \FilterIterator implements \Countable
{
    public function __construct(Iterator $iterator)
    {
        parent::__construct($iterator);
    }

    public function count(): int
    {
        $a = iterator_to_array($this);
        return count($a);
    }

    public function accept(): bool
    {
        $current = parent::current();
        if ($current instanceof RecordInterface) {
            return $current->isValid();
        }

        throw new \InvalidArgumentException(self::class.' is appliable only to iterator of implementation of '.RecordInterface::class);
    }
}
