<?php

declare(strict_types=1);

namespace Imigio\Service\Dto;

class StorageResponse implements ResponseInterface
{
    private ?string $id = null;

    private ?string $filename8 = null;

    private ?string $filename = null;

    private ?int $size = null;

    private ?string $mimeType = null;

    private ?string $url = null;

    private array $types = [];

//  "filename8": "21aa510a",
//	"filename": "21aa510aa92d0a666bcc219fa1882cc2b2dc81c4",
//	"size": 597590,
//	"mimeType": "image\/webp",
//	"url": "https:\/\/imig.io.local\/api\/storage\/21aa510a.webp",
//	"types": {
//		"image": "https:\/\/dupa.blada\/api\/storage\/21aa510a\/image\/abc.webp"
//	}

    public static function fromArray(array $contents): StorageResponse
    {
        $storageOutput = new self();
        $storageOutput->id = $contents['id'] ?? null;
        $storageOutput->filename8 = $contents['filename8'] ?? null;
        $storageOutput->filename = $contents['filename'] ?? null;
        $storageOutput->size = $contents['size'] ?? null;
        $storageOutput->mimeType = $contents['mimeType'] ?? null;
        $storageOutput->url = $contents['url'] ?? null;
        $storageOutput->types = $contents['types'] ?? null;

        return $storageOutput;
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
}
