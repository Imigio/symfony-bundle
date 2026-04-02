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
                    ->defaultValue('')
                ->end()
                ->scalarNode('cname')->end()
                ->scalarNode('placeholder')
                    ->defaultValue('/assets/images/placeholder.svg')
                ->end()

                ->arrayNode('relations')
                    ->isRequired()
                    ->defaultValue([])
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
