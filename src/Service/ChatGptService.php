<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatGptService extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function generateResponse(array $tasks): JsonResponse
    {
        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer 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',
            ],
            'json' => [
                'prompt' => 'Hello, ChatGPT!',
                'max_tokens' => 150,
                'temperature' => 0.5,
            ],
        ]);


        $responseData = json_decode($response->getContent(), true);
        $generatedText = $responseData['choices'][0]['text'];

        dump($generatedText);
        return new JsonResponse($response->toArray());
    }

}