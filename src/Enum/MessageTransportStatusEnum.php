<?php

namespace App\Enum;

class MessageTransportStatusEnum extends Enum
{
    const PENDING = 'pend';
    const IN_PROGRESS = 'prog';
    const SENT = 'sent';
    const RECEIVED = 'rcvd';

    /**
     * @var array
     */
    protected static $options = [
        self::PENDING,
        self::IN_PROGRESS,
        self::SENT,
        self::RECEIVED
    ];
}
