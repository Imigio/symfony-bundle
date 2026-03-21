<?php

declare(strict_types=1);

namespace Imigio\DependencyInjection\CompilerPass;

use Imigio\Service\ImigioClient;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $def = $container->getDefinition(ImigioClient::class);
        $def->setArgument(0, $container->getParameter('imigioConfig')['token'] ?? '');
    }
}
