<?php

namespace App\Handler;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ClientHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Client $client)
    {

        $this->entityManager->persist($client);
        $this->entityManager->flush(); // <- the error occurs here, but only when using an async transport handler

        echo "ok !";
    }
}