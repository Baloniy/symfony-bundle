<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle\Tests;

use Baloniy\LoremIpsumBundle\BaloniyIpsum;
use Baloniy\LoremIpsumBundle\BaloniyLoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class FunctionalTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new BaloniyLoremIpsumTestingKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('baloniy_lorem_ipsum.baloniy_ipsum');

        $this->assertInstanceOf(BaloniyIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());
    }
}

class BaloniyLoremIpsumTestingKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        return yield new BaloniyLoremIpsumBundle();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // TODO: Implement registerContainerConfiguration() method.
    }
}