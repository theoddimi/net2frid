<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Enum\MessageTransportStatusEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApiRequest
 * 
 * @ORM\Table(
 *      name = "message_transport",
 *          indexes = {
 *              @ORM\Index(name = "date_created_index", columns = {"date_created"}),
 *              @ORM\Index(name = "api_response_id_index", columns = {"api_response_id"}),
 *              @ORM\Index(name = "routing_key_index", columns = {"routing_key"})
 *          }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class MessageTransport extends BaseEntity {

    use Timestamp;

    /**
     * @var ApiResponse
     * 
     * @ORM\OneToOne(targetEntity = "ApiResponse")
     * @ORM\JoinColumn(referencedColumnName = "id", nullable = false)
     */
    private $apiResponse;

    /**
     * @var string
     * 
     * @ORM\Column(name = "routing_class", type = "string", nullable = true)
     */
    private $routingClass;

    /**
     * @var int
     * 
     * @ORM\Column(name = "routing_class_id", type = "integer", nullable = true)
     */
    private $routingClassId;

    /**
     * @var string
     * 
     * @ORM\Column(name = "transport", type = "text", nullable = true)
     */
    private $transport;

    /**
     * @var string
     * 
     * @ORM\Column(name = "routing_key", type = "string", nullable = false)
     */
    private string $routingKey;

    /**
     * @var string
     * 
     * @ORM\Column(name = "content", type = "text", nullable = true)
     */
    private string $content;

    /**
     * @var string
     * 
     * @ORM\Column(name = "status", type = "string", length = 4, nullable = false)
     */
    private string $status;

    protected function __construct()
    {
        $this->setDateCreated();
        $this->setDateUpdated();
        $this->setStatus(new MessageTransportStatusEnum(MessageTransportStatusEnum::PENDING));
    }

    /**
     * @param ApiResponse $apiResponse
     * 
     * @return MessageTransport
     */
    public static function create(ApiResponse $apiResponse): MessageTransport
    {
        $messageTransport = new self();
        $messageTransport->setApiResponse($apiResponse);

        return $messageTransport;
    }

    /**
     * @return ApiResponse
     */
    public function getApiResponse(): ApiResponse
    {
        return $this->apiResponse;
    }

    /**
     * @return string
     */
    public function getRoutingClass(): string
    {
        return $this->routingClass;
    }

    /**
     * @return int|null
     */
    public function getRoutingClassId(): ?int
    {
        return $this->routingClassId;
    }

    /**
     * @return string
     */
    public function getTransport(): string
    {
        return $this->transport;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return MessageTransportStatusEnum
     */
    public function getStatus(): MessageTransportStatusEnum
    {
        return new MessageTransportStatusEnum($this->status);
    }

    /**
     * @param ApiResponse $apiResponse
     * 
     * @return self
     */
    public function setApiResponse(ApiResponse $apiResponse): self
    {
        $this->apiResponse = $apiResponse;

        return $this;
    }

    /**
     * @param string $routingClass
     * 
     * @return self
     */
    public function setRoutingClass(string $routingClass): self
    {
        $this->routingClass = $routingClass;

        return $this;
    }

    /**
     * @param int|null $routingClassId
     * 
     * @return self
     */
    public function setRoutingClassId(?int $routingClassId): self
    {
        $this->routingClassId = $routingClassId;

        return $this;
    }

    /**
     * @param string $transport
     * 
     * @return self
     */
    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param string $routingKey
     * 
     * @return self
     */
    public function setRoutingKey(string $routingKey): self
    {
        $this->routingKey = $routingKey;

        return $this;
    }

    /**
     * @param string|null $content
     * 
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param MessageTransportStatusEnum $status
     * 
     * @return self
     */
    public function setStatus(MessageTransportStatusEnum $status): self
    {
        $this->status = $status->getValue();

        return $this;
    }
}
