<?php

namespace App\Message;

class GridMessage {

    /**
     * @var string
     */
    private int $messageValue;

    /**
     * @var int
     */
    private int $timestamp;
    
    /**
     * @var int
     */
    private int $transportId;

    /**
     * @param int $value
     * @param int $timestamp
     * @param int $transportId
     */
    public function __construct(int $value, int $timestamp, int $transportId)
    {
        $this->messageValue = $value;
        $this->timestamp = $timestamp;
        $this->transportId = $transportId;
    }

    /**
     * @return int
     */
    public function getMessageValue(): int
    {
        return $this->messageValue;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
    
    /**
     * @return int
     */
    public function getTransportId(): int
    {
        return $this->transportId;
    }
}
