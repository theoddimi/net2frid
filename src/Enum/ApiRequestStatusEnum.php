<?php

namespace App\Enum;

class ApiRequestStatusEnum extends Enum
{
    const PENDING = 'pend';
    const IN_PROGRESS = 'prog';
    const SENT = 'sent';
    const FAILED_TO_SEND = 'fail';

    /**
     * @var array
     */
    protected static $options = [
        self::PENDING,
        self::IN_PROGRESS,
        self::SENT,
        self::FAILED_TO_SEND
    ];
}
