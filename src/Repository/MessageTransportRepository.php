<?php

namespace App\Repository;

use App\Entity\MessageTransport;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MessageTransportRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $mainEntityManager;

    /**
     * @var EntityRepository
     */
    private EntityRepository $entityRepository;
    
    public function __construct(EntityManagerInterface $mainEntityManager)
    {
        $this->mainEntityManager = $mainEntityManager;
        $this->entityRepository = $this->mainEntityManager->getRepository(MessageTransport::class);
    }

    /**
     * @param int $id
     * 
     * @return MessageTransport|null
     */
    public function findById(int $id): ?MessageTransport
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }
    
    /**
     * @param MessageTransport $messageTransport
     * 
     * @return void
     */
    public function save(MessageTransport $messageTransport): void
    {
        $this->mainEntityManager->persist($messageTransport);
        $this->mainEntityManager->flush();
    }
    
    /**
     * @param MessageTransport $messageTransport
     * 
     * @return void
     */
    public function delete(MessageTransport $messageTransport): void
    {
        $this->mainEntityManager->remove($messageTransport);
        $this->mainEntityManager->flush();
    }
}
