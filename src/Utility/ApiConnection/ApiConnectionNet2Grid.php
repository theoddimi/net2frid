<?php

namespace App\Utility\ApiConnection;

use App\Entity\ApiRequest;
use App\Entity\ApiResponse;
use App\Enum\HttpRequestMethodEnum;

class ApiConnectionNet2Grid extends ApiConnectionBase {

    /**
     * @param string $url
     * 
     * @return ApiResponse
     */
    public function consumeMessageFromUrl(string $url): ApiResponse
    {
        $apiRequest = ApiRequest::create(HttpRequestMethodEnum::createGet(), $url);

        return $this->saveAndExecuteApiRequest($apiRequest);
    }
}
