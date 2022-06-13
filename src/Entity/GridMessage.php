<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Objects\ApiGridObject;
use App\Objects\RoutingKey;
use App\Message\GridMessage as GridMessengerMessage;
use Doctrine\ORM\Mapping as ORM;

/**
 * GridMessage
 * 
 * @ORM\Table(
 *      name = "grid_message",
 *          indexes = {
 *              @ORM\Index(name = "date_created_index", columns = {"date_created"}),
 *              @ORM\Index(name = "message_transport_id_index", columns = {"message_transport_id"}),
 *              @ORM\Index(name = "gateway_eui_index", columns = {"http_request_method"}),
 *              @ORM\Index(name = "profile_id_index", columns = {"profile_id"}),
 *              @ORM\Index(name = "endpoint_id_index", columns = {"endpoint_id"}),
 *              @ORM\Index(name = "cluster_id_index", columns = {"cluster_id"}),
 *              @ORM\Index(name = "attribute_id_index", columns = {"attribute_id"}),
 *          }
 * )
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class GridMessage extends BaseEntity {

    use Timestamp;

    /**
     * @var MessageTransport
     * 
     * @ORM\OneToOne(targetEntity = "MessageTransport")
     * @ORM\JoinColumn(referencedColumnName = "id", nullable = false)
     */
    private $messageTransport;

    /**
     * @var string
     * 
     * @ORM\Column(name = "gateway_eui", type = "string", length = 100, nullable = false)
     */
    public string $gatewayEui;

    /**
     * @var string
     * 
     * @ORM\Column(name = "profile_id", type = "string", length = 100, nullable = false)
     */
    public string $profileId;

    /**
     * @var string
     * 
     * @ORM\Column(name = "endpoint_id", type = "string", length = 100, nullable = false)
     */
    public string $endpointId;

    /**
     * @var string
     * 
     * @ORM\Column(name = "cluster_id", type = "string", length = 100, nullable = false)
     */
    public string $clusterId;

    /**
     * @var string
     * 
     * @ORM\Column(name = "attribute_id", type = "string", length = 100, nullable = false)
     */
    public string $attributeId;

    /**
     * @var int
     * 
     * @ORM\Column(name = "value", type = "integer", nullable = false)
     */
    public int $value;

    /**
     * @var int
     * 
     * @ORM\Column(name = "timestamp", type = "integer", nullable = false)
     */
    public int $timestamp;

    protected function __construct()
    {
        $this->setDateCreated();
        $this->setDateUpdated();
    }

    /**
     * @param ApiGridObject $apiGrid
     * 
     * @return self
     */
    public static function createFromMessageTransportAndGridMessage(
            MessageTransport $messageTransport,
            GridMessengerMessage $gridMessage
    ): self {
        $routingKey = RoutingKey::decomposeRoutingKey($messageTransport->getRoutingKey());

        $gridMessageEntity = new self();
        $gridMessageEntity->setMessageTransport($messageTransport);
        $gridMessageEntity->setGatewayEui($routingKey->getGatewayEui());
        $gridMessageEntity->setProfileId($routingKey->getProfileId());
        $gridMessageEntity->setEndpointId($routingKey->getEndpointId());
        $gridMessageEntity->setClusterId($routingKey->getClusterId());
        $gridMessageEntity->setAttributeId($routingKey->getAttributeId());
        $gridMessageEntity->setValue($gridMessage->getMessageValue());
        $gridMessageEntity->setTimestamp($gridMessage->getTimestamp());

        return $gridMessageEntity;
    }

    /**
     * @return MessageTransport
     */
    public function getMessageTransport(): MessageTransport
    {
        return $this->apiResponse;
    }

    /**
     * @return string
     */
    public function getGatewayEui(): string
    {
        return $this->gatewayEui;
    }

    /**
     * @return string
     */
    public function getProfileId(): string
    {
        return $this->profileId;
    }

    /**
     * @return string
     */
    public function getEndpointId(): string
    {
        return $this->endpointId;
    }

    /**
     * @return string
     */
    public function getClusterId(): string
    {
        return $this->clusterId;
    }

    /**
     * @return string
     */
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param MessageTransport $messageTransport
     * 
     * @return self
     */
    public function setMessageTransport(MessageTransport $messageTransport): self
    {
        $this->messageTransport = $messageTransport;

        return $this;
    }

    /**
     * @param string $gatewayEui
     * 
     * @return self
     */
    public function setGatewayEui(string $gatewayEui): self
    {
        $this->gatewayEui = $gatewayEui;

        return $this;
    }

    /**
     * @param string $profileId
     * 
     * @return self
     */
    public function setProfileId(string $profileId): self
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * @param string $endpointId
     * 
     * @return self
     */
    public function setEndpointId(string $endpointId): self
    {
        $this->endpointId = $endpointId;

        return $this;
    }

    /**
     * @param string $clusterId
     * 
     * @return self
     */
    public function setClusterId(string $clusterId): self
    {
        $this->clusterId = $clusterId;

        return $this;
    }

    /**
     * @param string $attributeId
     * 
     * @return self
     */
    public function setAttributeId(string $attributeId): self
    {
        $this->attributeId = $attributeId;

        return $this;
    }

    /**
     * @param int $value
     * 
     * @return self
     */
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param int $timestamp
     * 
     * @return self
     */
    public function setTimestamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

}
