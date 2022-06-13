<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Enum\ApiRequestStatusEnum;
use App\Enum\HttpRequestMethodEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApiRequest
 * 
 * @ORM\Table(
 *      name = "api_request",
 *          indexes = {
 *              @ORM\Index(name = "date_created_index", columns = {"date_created"}),
 *              @ORM\Index(name = "http_request_method_index", columns = {"http_request_method"}),
 *              @ORM\Index(name = "status_index", columns = {"status"})
 *          }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ApiRequest extends BaseEntity {

    use Timestamp;

    /**
     * @var string
     * 
     * @ORM\Column(name = "http_request_method", type = "string", length = 20, nullable = false)
     */
    private $httpRequestMethod;

    /**
     * @var string
     * 
     * @ORM\Column(name = "url", type = "string", length = 1500, nullable = false)
     */
    private $url;

    /**
     * @var string
     * 
     * @ORM\Column(name = "request_header", type = "text", nullable = true)
     */
    private $requestHeader;

    /**
     * @var string
     * 
     * @ORM\Column(name = "request_body", type = "text", nullable = true)
     */
    private $requestBody;

    /**
     * @var ApiRequestStatusEnum
     * 
     * @ORM\Column(name = "status", type = "api_request_status", length = 4, nullable = false)
     */
    private $status;

    protected function __construct()
    {
        $this->setDateCreated();
        $this->setDateUpdated();
    }

    /**
     * @param HttpRequestMethodEnum $httpRequestMethod
     * @param string $url
     * 
     * @return ApiRequest
     */
    public static function create(HttpRequestMethodEnum $httpRequestMethod, string $url): ApiRequest
    {
        $apiRequest = new ApiRequest();
        $apiRequest->setHttpRequestMethod($httpRequestMethod);
        $apiRequest->setStatus(new ApiRequestStatusEnum(ApiRequestStatusEnum::IN_PROGRESS));
        $apiRequest->setUrl($url);

        return $apiRequest;
    }

    /**
     * @return HttpRequestMethodEnum
     */
    public function getHttpRequestMethod(): HttpRequestMethodEnum
    {
        return new HttpRequestMethodEnum($this->httpRequestMethod);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getRequestHeader(): ?string
    {
        return $this->requestHeader;
    }

    /**
     * @return string|null
     */
    public function getRequestBody(): ?string
    {
        return $this->requestBody;
    }

    /**
     * @return ApiRequestStatusEnum
     */
    public function getStatus(): ApiRequestStatusEnum
    {
        return $this->status;
    }

    /**
     * @param HttpRequestMethodEnum $httpRequestMethod
     * 
     * @return self
     */
    public function setHttpRequestMethod(HttpRequestMethodEnum $httpRequestMethod): self
    {
        $this->httpRequestMethod = $httpRequestMethod->getValue();

        return $this;
    }

    /**
     * @param string $url
     * 
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string|null $requestHeader
     * 
     * @return self
     */
    public function setRequestHeader(?string $requestHeader): self
    {
        $this->requestHeader = $requestHeader;

        return $this;
    }

    /**
     * @param string|null $requestBody
     * 
     * @return self
     */
    public function setRequestBody(?string $requestBody): self
    {
        $this->requestBody = $requestBody;

        return $this;
    }

    /**
     * @param ApiRequestStatusEnum $status
     * 
     * @return self
     */
    public function setStatus(ApiRequestStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }
}
