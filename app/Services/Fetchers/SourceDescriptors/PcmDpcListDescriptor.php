<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Fetchers\Contracts\SourceListDescriptorInterface;
use App\Services\Ranges\DateRange;

class PcmDpcListDescriptor implements SourceListDescriptorInterface
{
    private readonly string $regexp;
    public function __construct(string $filePrefix)
    {
        $this->regexp = '/'.$filePrefix.'([0-9]{8})\.csv/';
    }

    public function isValidSource(array|string $source, DateRange $range): bool
    {
        if (0 === preg_match($this->regexp, $source, $matches)) {
            return false;
        }

        $fileDatetime = \DateTime::createFromFormat('Ymd H:i:s', $matches[1].' 00:00:00');

        if (empty($fileDatetime)) {
            return false;
        }

        return $range->includes($fileDatetime);
    }


}
