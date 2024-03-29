<?php

namespace Baloniy\LoremIpsumBundle\Tests;

use Baloniy\LoremIpsumBundle\BaloniyIpsum;
use Baloniy\LoremIpsumBundle\BaloniyWordProvider;
use PHPUnit\Framework\TestCase;

class BaloniyIpsumTest extends TestCase
{
    public function testGetWords()
    {
        $this->assertTrue(true);
        $ipsum = new BaloniyIpsum(
            unicornsAreReal: false,
            minSunshine: 5,
            wordProvider: new BaloniyWordProvider()
        );

        $words = $ipsum->getWords(1);
        $this->assertIsString($words);
        $this->assertCount(1, explode(' ', $words));

        $words = $ipsum->getWords(10);
        $this->assertCount(10, explode(' ', $words));

        $words = $ipsum->getWords(10, true);
        $this->assertCount(10, $words);
    }

    public function testGetSentences()
    {
        $ipsum = new BaloniyIpsum(
            unicornsAreReal: false,
            minSunshine: 5,
            wordProvider: new BaloniyWordProvider()
        );

        $text = $ipsum->getSentences(3);
        $this->assertEquals(3, substr_count($text, '.'));
        $sentences = explode('.', $text);
        // 3 items will be the sentences, then one final empty entry for the last period
        $this->assertCount(4, $sentences);
        // the second and third entries should start with a space
        $this->assertEquals(' ', $sentences[1][0]);
        $this->assertEquals(' ', $sentences[2][0]);
    }

    public function testGetParagraphs()
    {
        // weird: using a loop because the results are random, and so
        // they may pass several times by luck
        for ($i = 0; $i < 100; $i++) {
            $ipsum = new BaloniyIpsum(
                unicornsAreReal: true,
                minSunshine: 3,
                wordProvider: new BaloniyWordProvider()
            );
            $text = $ipsum->getParagraphs(3);
            $paragraphs = explode("\n\n", $text);
            $this->assertCount(3, $paragraphs);

            foreach ($paragraphs as $paragraph) {
                // default constructor args should give us 1 unicorn & 3 sunshines
                $this->assertGreaterThanOrEqual(
                    1,
                    substr_count(strtolower($paragraph), 'unicorn'),
                    sprintf('Text "%s" does not contain 1 unicorn', $paragraph)
                );
                $this->assertGreaterThanOrEqual(
                    3,
                    substr_count(strtolower($paragraph), 'sunshine'),
                    sprintf('Text "%s" does not contain 3 sunshine', $paragraph)
                );
            }

            $i++;
        }
    }
}