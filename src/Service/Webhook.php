<?php

namespace App\Service;

use App\Entity\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Webhook
{
    private HttpClientInterface $client;

    private string $token;

    /**
     * @param string $token
     * @param HttpClientInterface $client
     */
    public function __construct(string $token, HttpClientInterface $client)
    {
        $this->token = $token;
        $this->client = $client;
    }

    public function send(Client $client)
    {
        $response = $this->client->request(
            'POST',
            'https://webhook.site/' . $this->token,
            [
                'body' => [
                    'data' => json_encode([
                        'name' => $client->getFirstName(),
                        'firstName' => $client->getFirstName(),
                        'email' => $client->getEmail(),
                        'phoneNumber' => $client->getPhoneNumber()
                    ])
                ]
            ]
        );

        $statusCode = $response->getStatusCode();

        dd($this->token);
    }
}