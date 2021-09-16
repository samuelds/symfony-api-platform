<?php

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

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
        $this->token  = $token;
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function send(Client $client)
    {
        // Push to weebhook.site
        return $this->client->request(
            'POST',
            'https://webhook.site/' . $this->token,
            [
                'body' => [
                    'data' => json_encode([
                        'name'        => $client->getFirstName(),
                        'firstName'   => $client->getFirstName(),
                        'email'       => $client->getEmail(),
                        'phoneNumber' => $client->getPhoneNumber()
                    ])
                ]
            ]
        );
    }
}