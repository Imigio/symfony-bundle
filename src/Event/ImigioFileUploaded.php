<?php

declare(strict_types=1);

namespace Imigio\Event;

use Imigio\Service\Dto\StorageResponse;

class ImigioFileUploaded
{
    public function __construct(
        private StorageResponse $storageResponse,
        private object $relation,
    )
    {}

    public function getStorageResponse(): StorageResponse
    {
        return $this->storageResponse;
    }

    public function getRelation(): object
    {
        return $this->relation;
    }
}
