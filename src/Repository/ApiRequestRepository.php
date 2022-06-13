<?php

namespace App\Repository;

use App\Entity\ApiRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ApiRequestRepository
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
        $this->entityRepository = $this->mainEntityManager->getRepository(ApiRequest::class);
    }

    /**
     * @param int $id
     * 
     * @return ApiRequest|null
     */
    public function findById(int $id): ?ApiRequest
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }
    
    /**
     * @param ApiRequest $apiRequest
     * 
     * @return void
     */
    public function save(ApiRequest $apiRequest): void
    {
        $this->mainEntityManager->persist($apiRequest);
        $this->mainEntityManager->flush();
    }
    
    /**
     * @param ApiRequest $apiRequest
     * 
     * @return void
     */
    public function delete(ApiRequest $apiRequest): void
    {
        $this->mainEntityManager->remove($apiRequest);
        $this->mainEntityManager->flush();
    }
}
