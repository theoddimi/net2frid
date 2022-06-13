<?php

namespace App\Repository;

use App\Entity\GridMessage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class GridMessageRepository
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
        $this->entityRepository = $this->mainEntityManager->getRepository(GridMessage::class);
    }

    /**
     * @param int $id
     * 
     * @return GridMessage|null
     */
    public function findById(int $id): ?GridMessage
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }
    
    /**
     * @param GridMessage $gridMessage
     * 
     * @return void
     */
    public function save(GridMessage $gridMessage): void
    {
        $this->mainEntityManager->persist($gridMessage);
        $this->mainEntityManager->flush();
    }
    
    /**
     * @param GridMessage $gridMessage
     * 
     * @return void
     */
    public function delete(GridMessage $gridMessage): void
    {
        $this->mainEntityManager->remove($gridMessage);
        $this->mainEntityManager->flush();
    }
}
