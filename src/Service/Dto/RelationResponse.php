<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

class RelationResponse implements ResponseInterface
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?int $size = null;

    private ?string $fileSizeLimit = null;

    private array $mimeTypes = [];

    public static function fromArray(array $contents): RelationResponse
    {
        $storageOutput = new self();
        $storageOutput->id = $contents['id'] ?? null;
        $storageOutput->name = $contents['name'] ?? null;
        $storageOutput->description = $contents['description'] ?? null;
        $storageOutput->size = $contents['size'] ?? null;
        $storageOutput->fileSizeLimit = $contents['fileSizeLimit'] ?? null;
        $storageOutput->mimeTypes = $contents['mimeTypes'] ?? null;

        return $storageOutput;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getFileSizeLimit(): ?string
    {
        return $this->fileSizeLimit;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getMimeTypes(): array
    {
        return $this->mimeTypes;
    }
}
