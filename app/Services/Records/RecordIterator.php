<?php

namespace App\Services\Records;

class RecordIterator implements \Iterator, \Countable
{
    private int $index = 0;

    private array $cache = [];
    public function __construct(private readonly array $rows, private readonly string $recordClass)
    {
    }

    public function current(): mixed
    {
        if (false === isset($this->cache[$this->index])) {
            $this->cache[$this->index] = new $this->recordClass($this->rows[$this->index]);
        }
        return $this->cache[$this->index];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->rows[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function count(): int
    {
        return count($this->rows);
    }
}
