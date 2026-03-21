<?php

declare(strict_types=1);

namespace Imigio;

use Imigio\DependencyInjection\CompilerPass\CompilerPass;
use Imigio\DependencyInjection\ImigioExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ImigioBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new CompilerPass);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ImigioExtension();
    }
}
