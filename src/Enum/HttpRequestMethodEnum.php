<?php

namespace App\Enum;

class HttpRequestMethodEnum extends Enum {

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';

    /**
     * @var array
     */
    protected static $options = [
        self::HTTP_METHOD_GET,
        self::HTTP_METHOD_POST,
        self::HTTP_METHOD_PUT,
        self::HTTP_METHOD_DELETE
    ];

    /**
     * @return HttpRequestMethodEnum
     */
    public static function createGet(): HttpRequestMethodEnum
    {
        return new HttpRequestMethodEnum(self::HTTP_METHOD_GET);
    }
}
