<?php

declare(strict_types=1);

namespace Imigio\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ImigioConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('imigio');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('token')
                    ->isRequired()
                ->end()
                ->scalarNode('cname')->end()

                ->arrayNode('relations')
                    ->isRequired()
//                    ->requiresAtLeastOneElement()
                    ->defaultValue([])
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
