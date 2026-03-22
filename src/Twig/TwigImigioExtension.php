<?php

declare(strict_types=1);

namespace Imigio\Twig;

use Symfony\Component\DependencyInjection\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigImigioExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('imigio_url', [
                $this,
                'imigioUrl',
            ]),
        ];
    }

    public function imigioUrl(string $filename, string $storageTypeName = null): ?string
    {
        if (null === $storageTypeName) {
            $path = sprintf(
                '/api/storage/%s.jpg',
                $filename,
            );
        }
        else {
            $path = sprintf(
                '/api/storage/%s/%s.jpg',
                $storageTypeName,
                $filename,
            );
        }

        return 'https://imig.io' . $path;
    }
}
