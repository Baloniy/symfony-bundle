<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle;

interface WordProviderInterface
{
    public function getWordList(): array;
}