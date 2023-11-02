<?php

namespace App\Services\Connectors\Contracts;

interface LoaderInterface
{
    public function supports(string $dataSet): bool;

    public function load(\DateTime $from = null, \DateTime $to = null): array;
}
