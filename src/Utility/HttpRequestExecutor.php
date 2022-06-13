<?php

namespace App\Utility;

use App\Entity\ApiRequest;
use App\Entity\ApiResponse;
use App\Enum\ApiRequestStatusEnum;
use App\Enum\ApiResponseResultEnum;
use App\Repository\ApiRequestRepository;
use App\Repository\ApiResponseRepository;
use Exception;

class HttpRequestExecutor {
    
    /**
     * @var string
     */
    private string $header;

    /**
     * @var ApiRequestRepository
     */
    protected ApiRequestRepository $apiRequestRepository;

    /**
     * @var ApiResponseRepository
     */
    protected ApiResponseRepository $apiResponseRepository;

    /**
     * @param ApiRequestRepository $apiRequestRepository
     * @param ApiResponseRepository $apiResponseRepository
     */
    public function __construct(
            ApiRequestRepository $apiRequestRepository,
            ApiResponseRepository $apiResponseRepository
    ){
        $this->apiRequestRepository = $apiRequestRepository;
        $this->apiResponseRepository = $apiResponseRepository;
    }

    /**
     * @param ApiRequest $apiRequest
     * 
     * @return ApiResponse
     * @throws Exception
     */
    public function executeApiRequest(ApiRequest $apiRequest): ApiResponse
    {
        try {
            $this->header = '';
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiRequest->getUrl(),
                CURLOPT_CUSTOMREQUEST => $apiRequest->getHttpRequestMethod()->getValue(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADERFUNCTION => [$this, "headerCallback"]
            ]);

            /**
             * @todo CURLOPT for headers and body
             */
            $response = curl_exec($curl);
            $responseCode = strval(curl_getinfo($curl, CURLINFO_HTTP_CODE));

            $apiRequest->setStatus(new ApiRequestStatusEnum(ApiRequestStatusEnum::SENT));
            $this->apiRequestRepository->save($apiRequest);

            $apiResponseResult = $this->getApiResponseResultFromApiRequestResponseCode(intval($responseCode));

            $apiResponse = ApiResponse::create($apiResponseResult, $apiRequest, $this->header, $responseCode);
            $apiResponse->setResponseBody($response);

            $this->apiResponseRepository->save($apiResponse);
            
            curl_close($curl);
        } catch (Exception $exception) {
            $apiRequest->setStatus(new ApiRequestStatusEnum(ApiRequestStatusEnum::FAILED_TO_SEND));
            
            throw $exception;
        }

        return $apiResponse;
    }

    /**
     * @param string $responseCode
     * 
     * @return ApiResponseResultEnum
     */
    private function getApiResponseResultFromApiRequestResponseCode(string $responseCode): ApiResponseResultEnum
    {
        if (200 === intval($responseCode)) {
            return new ApiResponseResultEnum(ApiResponseResultEnum::SUCCESS);
        }

        return new ApiResponseResultEnum(ApiResponseResultEnum::FAIL);
    }
    
    /**
     * @param type $curl
     * @param type $headerLine
     * 
     * @return int
     */
    public function headerCallback($curl, $headerLine): int
    {
        $this->header .= $headerLine;
        
        return strlen($headerLine);
    }
}
