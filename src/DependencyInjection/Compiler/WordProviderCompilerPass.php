<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class WordProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('baloniy_lorem_ipsum.baloniy_ipsum');
        $references = [];

        $taggedServices = $container->findTaggedServiceIds('baloniy_ipsum_word_provider');

        foreach ($taggedServices as $id => $taggedServiceId) {
            $references[] = new Reference($id);
        }

        $definition->setArgument(2, $references);
    }
}