<?php

namespace App\Services\Fetchers\SourceDescriptors;

use App\Services\Fetchers\Contracts\SourceDescriptorInterface;

class GithubSourceDescriptor implements SourceDescriptorInterface
{
    use IsRecordSource;
    public function __construct(private readonly string $repository, private readonly string $path, string $recordClass)
    {
        $this->setRecordClass($recordClass);
    }

    /**
     * @inheritDoc
     */
    public function getResourceUrl(): string
    {
        return 'https://api.github.com/repos/'.$this->repository.'/contents/'.$this->path;
    }

    /**
     * @inheritDoc
     */
    public function getResourceToExtract($resourceDescription): mixed
    {
        return $resourceDescription['download_url'];
    }
}
