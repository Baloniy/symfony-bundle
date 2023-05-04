<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle;

use Baloniy\LoremIpsumBundle\DependencyInjection\BaloniyLoremIpsumExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class BaloniyLoremIpsumBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new BaloniyLoremIpsumExtension();
    }
}