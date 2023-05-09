<?php

declare(strict_types=1);

namespace Baloniy\LoremIpsumBundle\Controller;

use Baloniy\LoremIpsumBundle\BaloniyIpsum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IpsumApiController extends AbstractController
{
    public function __construct(
        private readonly BaloniyIpsum $baloniyIpsum,
    ) {
    }

    public function index(): JsonResponse
    {
        return $this->json([
            'paragraphs' => $this->baloniyIpsum->getParagraphs(),
            'sentences' => $this->baloniyIpsum->getSentences()
        ]);
    }
}