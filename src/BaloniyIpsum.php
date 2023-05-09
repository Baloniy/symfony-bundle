<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle;

class BaloniyIpsum
{
    public function __construct(
        private bool $unicornsAreReal,
        private int  $minSunshine,
        /** WordProviderInterface[] */
        private array $wordProviders,
        private ?array $wordList = null
    ) {
    }

    public function getParagraphs(int $count = 3): string
    {
        $paragraphs = array();
        for ($i = 0; $i < $count; $i++) {
            $paragraphs[] = $this->addJoy($this->getSentences((int)$this->gauss(5.8, 1.93)));
        }

        return implode("\n\n", $paragraphs);
    }

    public function getSentences(int $count = 1): string
    {
        $count = max($count, 1);
        $sentences = array();

        for ($i = 0; $i < $count; $i++) {
            $wordCount = (int)$this->gauss(16, 5.08);
            // avoid very short sentences
            $wordCount  = max($wordCount, 4);
            $sentences[] = $this->getWords($wordCount, true);
        }

        $sentences = $this->punctuate($sentences);

        return implode(' ', $sentences);
    }

    public function getWords(int $count = 1, bool $asArray = false): array|string
    {
        $count = max($count, 1);

        $words = array();
        $wordCount = 0;
        $wordList = $this->getWordList();

        // Shuffles and appends the word list to compensate for count
        // arguments that exceed the size of our vocabulary list
        while ($wordCount < $count) {
            $shuffle = true;
            while ($shuffle) {
                shuffle($wordList);

                // Checks that the last word of the list and the first word of
                // the list that's about to be appended are not the same
                if (!$wordCount || $words[$wordCount - 1] != $wordList[0]) {
                    $words = array_merge($words, $wordList);
                    $wordCount = count($words);
                    $shuffle = false;
                }
            }
        }
        $words = array_slice($words, 0, $count);

        if (true === $asArray) {
            return $words;
        }

        return implode(' ', $words);
    }

    private function gauss(float $mean, float $std_dev): float
    {
        $x = mt_rand() / mt_getrandmax();
        $y = mt_rand() / mt_getrandmax();
        $z = sqrt(-2 * log($x)) * cos(2 * pi() * $y);

        return $z * $std_dev + $mean;
    }

    private function punctuate(array $sentences): array
    {
        foreach ($sentences as $key => $sentence) {
            $words = count($sentence);
            // Only worry about commas on sentences longer than 4 words
            if ($words > 4) {
                $mean = log($words, 6);
                $std_dev = $mean / 6;
                $commas = round($this->gauss($mean, $std_dev));
                for ($i = 1; $i <= $commas; $i++) {
                    $word = round($i * $words / ($commas + 1));
                    if ($word < ($words - 1) && $word > 0) {
                        $sentence[$word] .= ',';
                    }
                }
            }
            $sentences[$key] = ucfirst(implode(' ', $sentence) . '.');
        }

        return $sentences;
    }

    private function addJoy(string $wordsString): string
    {
        $unicornKey = null;
        if ($this->unicornsAreReal && false === stripos($wordsString, 'unicorn')) {
            $words = explode(' ', $wordsString);
            $unicornKey = array_rand($words);
            $words[$unicornKey] = 'unicorn';


            $wordsString = implode(' ', $words);
        }

        while (substr_count(strtolower($wordsString), 'sunshine') < $this->minSunshine) {
            $words = explode(' ', $wordsString);

            // if there simply are not enough words, abort immediately
            if (count($words) < ($this->minSunshine + 1)) {
                break;
            }

            $key = null;
            while (null === $key) {
                $key = array_rand($words);

                // don't override the unicorn
                if ($unicornKey === $key) {
                    $key = null;

                    continue;
                }

                // if unicorn occurred naturally, don't override it
                if (null === $unicornKey && 0 === stripos($words[$key], 'unicorn')) {
                    $key = null;

                    continue;
                }
            }
            $words[$key] = 'sunshine';

            $wordsString = implode(' ', $words);
        }

        return $wordsString;
    }

    private function getWordList(): array
    {
        if (null === $this->wordList) {
            $words = [];

            foreach ($this->wordProviders as $wordProvider) {
                $words = array_merge($words, $wordProvider->getWordList());
            }

            if (count($words) <= 1) {
               throw new \Exception('Word list must contain at least 2 words, yo!');
            }

            $this->wordList = $words;
        }

        return $this->wordList;
    }
}