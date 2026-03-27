<?php

declare(strict_types=1);

namespace Imigio\Event;

class ImigioFileDeleted
{
    public function __construct(
        private string $filename,
        private object $relation,
    )
    {}

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getRelation(): object
    {
        return $this->relation;
    }
}
