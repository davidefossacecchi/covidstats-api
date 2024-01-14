<?php

namespace App\Services\Ranges;

final class DateRange
{
    public function __construct(private readonly ?\DateTimeInterface $from = null, private readonly ?\DateTimeInterface $to = null)
    {
    }

    public function includes(\DateTimeInterface $dateTime): ?bool
    {
        if (isset($this->to) && $this->to < $dateTime) {
            return false;
        }

        if (isset($this->from) && $this->from > $dateTime) {
            return false;
        }

        return true;
    }

    public function getFrom(): ?\DateTimeInterface
    {
        return $this->from;
    }

    public function getTo(): ?\DateTimeInterface
    {
        return $this->to;
    }
}
