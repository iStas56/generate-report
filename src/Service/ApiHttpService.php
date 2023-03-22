<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ApiHttpService
{
    public function getTasks(array $params)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://evo.skillum.ru/api/task', [
            'query' => $params,
        ]);

        $status = $response->getStatusCode();
        $content = json_decode($response->getContent(), true);

        return $status === 200 ? $content : [];
    }
}