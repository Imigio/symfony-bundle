<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

use SplFileInfo;

readonly class UploadRequest
{
    public function __construct(
        private SplFileInfo $file,
        private string $relationName,
        private string $relationId,
    )
    {}

    public function getFile(): SplFileInfo
    {
        return $this->file;
    }

    public function getRelationName(): string
    {
        return $this->relationName;
    }

    public function getRelationId(): string
    {
        return $this->relationId;
    }
}
