<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

class StorageTypeResponse implements ResponseInterface
{
    private ?string $id = null;

    private ?string $relationName = null;

    private ?string $name = null;

    private ?string $label = null;

    private ?string $description = null;

    private ?string $scheme = null;

    private ?int $width = null;

    private ?int $height = null;

    private ?string $backgroundFillColor = null;

    public static function fromArray(array $contents): StorageTypeResponse
    {
        $storageTypeOutput = new self();
        $storageTypeOutput->id = $contents['id'] ?? null;
        $storageTypeOutput->relationName = $contents['relationName'] ?? null;
        $storageTypeOutput->name = $contents['name'] ?? null;
        $storageTypeOutput->label = $contents['label'] ?? null;
        $storageTypeOutput->description = $contents['description'] ?? null;
        $storageTypeOutput->scheme = $contents['scheme'] ?? null;
        $storageTypeOutput->width = $contents['width'] ?? null;
        $storageTypeOutput->height = $contents['height'] ?? null;
        $storageTypeOutput->backgroundFillColor = $contents['backgroundFillColor'] ?? null;

        return $storageTypeOutput;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRelationName(): ?string
    {
        return $this->relationName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getScheme(): ?int
    {
        return $this->scheme;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getBackgroundFillColor(): ?string
    {
        return $this->backgroundFillColor;
    }
}
