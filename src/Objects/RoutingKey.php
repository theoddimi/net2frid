<?php

namespace App\Objects;

use Exception;

class RoutingKey {

    /**
     * Error messages
     */
    const ERROR_KEY_NOT_EXISTS = '%s does not exist in routing key.';

    /**
     * Routing key data keys
     */
    const KEY_GATEWAY_EUI = 'gatewayEui';
    const KEY_PROFILE_ID = 'profileId';
    const KEY_ENDPOINT_ID = 'endpointId';
    const KEY_CLUSTER_ID = 'clusterId';
    const KEY_ATTRIBUTE_ID = 'attributeId';

    /**
     * Routing key data keys array
     */
    const ROUTING_KEY_KEYS = [
        self::KEY_GATEWAY_EUI,
        self::KEY_PROFILE_ID,
        self::KEY_ENDPOINT_ID,
        self::KEY_CLUSTER_ID,
        self::KEY_ATTRIBUTE_ID,
    ];

    /**
     * @var string
     */
    public string $gatewayEui;

    /**
     * @var string
     */
    public string $profileId;

    /**
     * @var string
     */
    public string $endpointId;

    /**
     * @var string
     */
    public string $clusterId;

    /**
     * @var string
     */
    public string $attributeId;


    /**
     * Constructor
     * 
     * @param array $data
     */
    private function __construct(array $data)
    {
        $this->gatewayEui = $data[self::KEY_GATEWAY_EUI];
        $this->profileId = $data[self::KEY_PROFILE_ID];
        $this->endpointId = $data[self::KEY_ENDPOINT_ID];
        $this->clusterId = $data[self::KEY_CLUSTER_ID];
        $this->attributeId = $data[self::KEY_ATTRIBUTE_ID];
    }

    /**
     * @param array $data
     * 
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        self::assertArrayHasValidKeys($data);

        return new self($data);
    }

    /**
     * @param ApiGridObject $apiGridObject
     * 
     * @return string
     */
    public static function composeRoutingKeyFromApiGridObject(ApiGridObject $apiGridObject): string
    {
        return $apiGridObject->gatewayEui .
                '.' . hexdec($apiGridObject->profileId) .
                '.' . hexdec($apiGridObject->endpointId) .
                '.' . hexdec($apiGridObject->clusterId) .
                '.' . hexdec($apiGridObject->attributeId);
    }
    
    /**
     * @param string $routingKey
     * 
     * @return self
     */
    public static function decomposeRoutingKey(string $routingKey): self
    {
        $routingKeyArray = explode('.', $routingKey);

        $data = [];
        $data[self::KEY_GATEWAY_EUI] = $routingKeyArray[0];
        $data[self::KEY_PROFILE_ID] = dechex($routingKeyArray[1]);
        $data[self::KEY_ENDPOINT_ID] = dechex($routingKeyArray[2]);
        $data[self::KEY_CLUSTER_ID] = dechex($routingKeyArray[3]);
        $data[self::KEY_ATTRIBUTE_ID] = dechex($routingKeyArray[4]);
        
        return self::createFromArray($data);
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
     * @param array $data
     * 
     * @return void
     * @throws Exception
     */
    private static function assertArrayHasValidKeys(array $data): void
    {
        foreach ($data as $key => $value) {
            if (false === array_search($key, self::ROUTING_KEY_KEYS)) {
                throw new Exception(sprintf(self::ERROR_KEY_NOT_EXISTS, $key));
            }
        }
    }
}
