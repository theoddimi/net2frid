<?php

namespace App\Utility\ApiConnection;

use App\Entity\ApiRequest;
use App\Entity\ApiResponse;
use App\Repository\ApiRequestRepository;
use App\Utility\HttpRequestExecutor;

class ApiConnectionBase {

    /**
     * @var HttpRequestExecutor
     */
    private HttpRequestExecutor $httpRequestExecutor;
    
    /**
     * @var ApiRequestRepository
     */
    protected ApiRequestRepository $apiRequestRepository;

    /**
     * @param HttpRequestExecutor $httpRequestExecutor
     * @param ApiRequestRepository $apiRequestRepository
     */
    public function __construct(
            HttpRequestExecutor $httpRequestExecutor,
            ApiRequestRepository $apiRequestRepository
    ) {
        $this->httpRequestExecutor = $httpRequestExecutor;
        $this->apiRequestRepository = $apiRequestRepository;
    }

    /**
     * @param ApiRequest $apiRequest
     * 
     * @return ApiResponse
     */
    protected function saveAndExecuteApiRequest(ApiRequest $apiRequest): ApiResponse
    {
        $this->apiRequestRepository->save($apiRequest);
        
        return $this->httpRequestExecutor->executeApiRequest($apiRequest);
    }
}
