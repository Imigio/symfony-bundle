<?php

declare(strict_types=1);

namespace Imigio\Twig;

use Imigio\Service\ImigioRouteGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigImigioExtension extends AbstractExtension
{
    public function __construct(
        private readonly ImigioRouteGenerator $imigioRouteGenerator,
    )
    {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('imigio_url', [
                $this,
                'imigioUrl',
            ]),
        ];
    }

    public function imigioUrl(?string $filename, string $storageTypeName = null): ?string
    {
        return $this->imigioRouteGenerator->generateImageUrl($filename, $storageTypeName);
    }
}
