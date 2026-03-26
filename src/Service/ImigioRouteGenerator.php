<?php

declare(strict_types=1);

namespace Imigio\Service;

readonly class ImigioRouteGenerator
{
    public function __construct(
        private ?string $imigioProjectCname = null,
    )
    {}

    private function getHostWithScheme(): string
    {
        if ($this->imigioProjectCname === null) {
            return 'https://imig.io';
        }

        return 'https://' . $this->imigioProjectCname;
    }

    public function generateImageUrl(?string $filename, string $storageTypeName = null, string $label = null): string
    {
        if (null === $filename) {
            return $this->getHostWithScheme() . '/assets/images/placeholder.svg';
        }

        if (null !== $storageTypeName && null !== $label) {
            $path = sprintf(
                '/storage/%s/%s-%s.jpg',
                $storageTypeName,
                $label,
                $filename,
            );
        }
        elseif (null !== $storageTypeName) {
            $path = sprintf(
                '/storage/%s/%s.jpg',
                $storageTypeName,
                $filename,
            );
        }
        else {
            $path = sprintf(
                '/storage/%s.jpg',
                $filename,
            );
        }

        return $this->getHostWithScheme() . $path;
    }
}
