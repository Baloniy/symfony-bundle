<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class BaloniyLoremIpsumExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ .'/../../config')
        );

        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('baloniy_lorem_ipsum.baloniy_ipsum');
        $definition->setArgument(0, $config['unicorns_are_real']);
        $definition->setArgument(1, $config['min_sunshine']);

        if ($config['word_provider'] !== null) {
            $container->setAlias('baloniy_lorem_ipsum.word_provider', $config['word_provider']);
        }
    }

    public function getAlias(): string
    {
        return 'baloniy_lorem_ipsum';
    }
}