<?php

namespace Baloniy\LoremIpsumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('baloniy_lorem_ipsum');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('unicorns_are_real')
                    ->defaultTrue()
                    ->info('Whether or not you believe in unicorns')
                    ->end()
                ->integerNode('min_sunshine')
                    ->defaultValue(3)
                    ->info('How much do you like sunshine?')
                    ->end()
                ->scalarNode('word_provider')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}