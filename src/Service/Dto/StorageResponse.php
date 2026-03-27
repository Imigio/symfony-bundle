<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

class StorageResponse implements ResponseInterface
{
    private ?string $id = null;

    private ?string $filename8 = null;

    private ?string $filename = null;

    private ?string $relationName = null;

    private ?string $relationId = null;

    private ?int $size = null;

    private ?string $mimeType = null;

    private ?string $url = null;

    private array $types = [];

    public static function fromArray(array $contents): StorageResponse
    {
        $storageOutput = new self();
        $storageOutput->id = $contents['id'] ?? null;
        $storageOutput->filename8 = $contents['filename8'] ?? null;
        $storageOutput->filename = $contents['filename'] ?? null;
        $storageOutput->relationName = $contents['relationName'] ?? null;
        $storageOutput->relationId = $contents['relationId'] ?? null;
        $storageOutput->size = $contents['size'] ?? null;
        $storageOutput->mimeType = $contents['mimeType'] ?? null;
        $storageOutput->url = $contents['url'] ?? null;
        $storageOutput->types = $contents['types'] ?? [];

        return $storageOutput;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'filename8' => $this->filename8,
            'filename' => $this->filename,
            'relationName' => $this->relationName,
            'relationId' => $this->relationId,
            'size' => $this->size,
            'mimeType' => $this->mimeType,
            'url' => $this->url,
            'types' => $this->types,
        ];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getFilename8(): ?string
    {
        return $this->filename8;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getRelationName(): ?string
    {
        return $this->relationName;
    }

    public function getRelationId(): ?string
    {
        return $this->relationId;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getTypeUrl(string $type): ?string
    {
        return $this->types[$type] ?? null;
    }
}
