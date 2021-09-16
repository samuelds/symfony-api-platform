<?php

namespace App\Handler;

use App\Entity\Client;
use App\Service\Webhook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ClientHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private Webhook $webhook;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Webhook $webhook
     */
    public function __construct(EntityManagerInterface $entityManager, Webhook $webhook)
    {
        $this->entityManager = $entityManager;
        $this->webhook = $webhook;
    }

    /**
     * @param Client $client
     * @throws TransportExceptionInterface
     */
    public function __invoke(Client $client)
    {
        // Push to webhook.site
        $response = $this->webhook->send($client);

        $code = $response->getStatusCode();

        if($code != 200)
        {
            // Action on error fo push
        }

        // Save on database !
        $this->entityManager->persist($client);
        $this->entityManager->flush();

    }
}