<?php

namespace Intriro\Bundle\CsvBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('intriro_csv');

        $rootNode
            ->children()
                ->arrayNode('importers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('delimiter')->defaultNull()->end()
                            ->scalarNode('enclosure')->defaultNull()->end()
                            ->scalarNode('escape')->defaultNull()->end()
                            ->scalarNode('to_charset')->defaultNull()->end()
                            ->scalarNode('from_charset')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('exporters')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('delimiter')->defaultNull()->end()
                            ->scalarNode('enclosure')->defaultNull()->end()
                            ->scalarNode('escape')->defaultNull()->end()
                            ->scalarNode('to_charset')->defaultNull()->end()
                            ->scalarNode('from_charset')->defaultNull()->end()
                            ->scalarNode('file_mode')->defaultNull()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
