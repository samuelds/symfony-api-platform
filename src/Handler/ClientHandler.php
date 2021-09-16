<?php

namespace App\Handler;

use App\Entity\Client;
use App\Service\Webhook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

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
     */
    public function __invoke(Client $client)
    {
        $this->webhook->send($client);
        //$this->entityManager->persist($client);
        //$this->entityManager->flush(); // <- the error occurs here, but only when using an async transport handler

        echo "ok !";
    }
}