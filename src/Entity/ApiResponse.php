<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Enum\ApiResponseResultEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApiRequest
 * 
 * @ORM\Table(
 *      name = "api_response",
 *          indexes = {
 *              @ORM\Index(name = "date_created_index", columns = {"date_created"}),
 *              @ORM\Index(name = "api_request_id_index", columns = {"api_request_id"}),
 *              @ORM\Index(name = "result_index", columns = {"result"})
 *          }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ApiResponse extends BaseEntity {

    use Timestamp;

    /**
     * @var ApiRequest
     * 
     * @ORM\OneToOne(targetEntity = "ApiRequest")
     * @ORM\JoinColumn(referencedColumnName = "id", nullable = false)
     */
    private $apiRequest;

    /**
     * @var string
     * 
     * @ORM\Column(name = "response_code", type = "string", length= 4, nullable = true)
     */
    private $responseCode;

    /**
     * @var string
     * 
     * @ORM\Column(name = "response_header", type = "text", nullable = true)
     */
    private $responseHeader;

    /**
     * @var string
     * 
     * @ORM\Column(name = "response_body", type = "text", nullable = true)
     */
    private $responseBody;

    /**
     * @var ApiResponseResultEnum
     * 
     * @ORM\Column(name = "result", type = "api_response_result", length = 4, nullable = false)
     */
    private $result;
    
    protected function __construct()
    {
        $this->setDateCreated();
        $this->setDateUpdated();
    }

    /**
     * @param ApiResponseResultEnum $responseResult
     * @param ApiRequest $apiRequest
     * @param string $headers
     * @param string $responseCode
     * 
     * @return ApiResponse
     */
    public static function create(
            ApiResponseResultEnum $responseResult,
            ApiRequest $apiRequest,
            string $headers,
            string $responseCode
    ): ApiResponse {
        $apiResponse = new ApiResponse();
        $apiResponse->setResult($responseResult);
        $apiResponse->setResponseHeader($headers);
        $apiResponse->setApiRequest($apiRequest);
        $apiResponse->setResponseCode($responseCode);
        
        return $apiResponse;
    }

    /**
     * @return ApiRequest
     */
    public function getApiRequest(): ApiRequest
    {
        return $this->apiRequest;
    }

    /**
     * @return string
     */
    public function getResponseCode(): string
    {
        return $this->responseCode;
    }

    /**
     * @return string
     */
    public function getResponseHeader(): string
    {
        return $this->responseHeader;
    }

    /**
     * @return string|null
     */
    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }

    /**
     * @return ApiResponseResultEnum
     */
    public function getResult(): ApiResponseResultEnum
    {
        return $this->result;
    }

    /**
     * @param ApiRequest $apiRequest
     * 
     * @return ApiResponse
     */
    public function setApiRequest(ApiRequest $apiRequest): ApiResponse
    {
        $this->apiRequest = $apiRequest;

        return $this;
    }

    /**
     * @param string $responseCode
     * 
     * @return ApiResponse
     */
    public function setResponseCode(string $responseCode): ApiResponse
    {
        $this->responseCode = $responseCode;
        
        return $this;
    }

    /**
     * @param string $responseHeader
     * 
     * @return ApiResponse
     */
    public function setResponseHeader(string $responseHeader): ApiResponse
    {
        $this->responseHeader = $responseHeader;

        return $this;
    }

    /**
     * @param string $responseBody
     * 
     * @return ApiResponse
     */
    public function setResponseBody(string $responseBody): ApiResponse
    {
        $this->responseBody = $responseBody;

        return $this;
    }

    /**
     * @param ApiResponseResultEnum $result
     * 
     * @return ApiResponse
     */
    public function setResult(ApiResponseResultEnum $result): ApiResponse
    {
        $this->result = $result;

        return $this;
    }
}
