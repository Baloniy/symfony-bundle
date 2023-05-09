<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle;

use Baloniy\LoremIpsumBundle\DependencyInjection\BaloniyLoremIpsumExtension;
use Baloniy\LoremIpsumBundle\DependencyInjection\Compiler\WordProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class BaloniyLoremIpsumBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new BaloniyLoremIpsumExtension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new WordProviderCompilerPass());
    }
}