<?php

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Webhook
{
    private HttpClientInterface $client;

    private EntityManagerInterface $em;

    private string $token;

    /**
     * @param string $token
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $em
     */
    public function __construct(string $token, HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->token  = $token;
        $this->client = $client;
        $this->em     = $em;
    }

    /**
     * @param Client $client
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
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
                        'name' => $client->getFirstName(),
                        'firstName' => $client->getFirstName(),
                        'email' => $client->getEmail(),
                        'phoneNumber' => $client->getPhoneNumber()
                    ])
                ]
            ]
        );
    }
}