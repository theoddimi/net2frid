<?php

namespace App\Repository;

use App\Entity\ApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ApiResponseRepository
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
        $this->entityRepository = $this->mainEntityManager->getRepository(ApiResponse::class);
    }

    /**
     * @param int $id
     * 
     * @return ApiResponse|null
     */
    public function findById(int $id): ?ApiResponse
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }
    
    /**
     * @param ApiResponse $apiResponse
     * 
     * @return void
     */
    public function save(ApiResponse $apiResponse): void
    {
        $this->mainEntityManager->persist($apiResponse);
        $this->mainEntityManager->flush();
    }
    
    /**
     * @param ApiResponse $apiResponse
     * 
     * @return void
     */
    public function delete(ApiResponse $apiResponse): void
    {
        $this->mainEntityManager->remove($apiResponse);
        $this->mainEntityManager->flush();
    }
}
