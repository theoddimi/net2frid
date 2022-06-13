<?php

namespace App\Enum;

class ApiResponseResultEnum extends Enum
{
    const SUCCESS = 'succ';
    const FAIL = 'fail';
    
    /**
     * @var array
     */
    protected static $options = [
        self::SUCCESS,
        self::FAIL
    ];
}
