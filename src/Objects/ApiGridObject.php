<?php

namespace App\Objects;

use Exception;

class ApiGridObject {

    /**
     * Error messages
     */
    const ERROR_KEY_NOT_EXISTS = '%s does not exist in response data.';

    /**
     * Consumed data keys
     */
    const KEY_GATEWAY_EUI = 'gatewayEui';
    const KEY_PROFILE_ID = 'profileId';
    const KEY_ENDPOINT_ID = 'endpointId';
    const KEY_CLUSTER_ID = 'clusterId';
    const KEY_ATTRIBUTE_ID = 'attributeId';
    const KEY_VALUE = 'value';
    const KEY_TIMESTAMP = 'timestamp';

    /**
     * Consumed data keys array
     */
    const GRID_KEYS = [
        self::KEY_GATEWAY_EUI,
        self::KEY_PROFILE_ID,
        self::KEY_ENDPOINT_ID,
        self::KEY_CLUSTER_ID,
        self::KEY_ATTRIBUTE_ID,
        self::KEY_VALUE,
        self::KEY_TIMESTAMP,
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
     * @var int
     */
    public int $value;

    /**
     * @var int
     */
    public int $timestamp;

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
        $this->value = $data[self::KEY_VALUE];
        $this->timestamp = $data[self::KEY_TIMESTAMP];
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
     * @param string $jsonData
     * 
     * @return array
     */
    public static function toArrayFromJson(string $jsonData): array
    {
        return json_decode($jsonData, true);
    }

    /**
     * @return string
     */
    public function setMessageBody(): string
    {
        return json_encode(
                [
                    self::KEY_VALUE => $this->value,
                    self::KEY_TIMESTAMP => $this->timestamp
                ]
        );
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
            if (false === array_search($key, self::GRID_KEYS)) {
                throw new Exception(sprintf(self::ERROR_KEY_NOT_EXISTS, $key));
            }
        }
    }
}
