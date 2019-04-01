<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:48
 */

namespace Sf4\Api\Response;

class OptionsResponse extends AbstractResponse
{
    public function init()
    {
        $request = $this->getRequest();
        $headers = $this->getResponseHeaders();
        if ($request) {
            $httpRequest = $request->getRequest();
            if ($httpRequest) {
                $requestHeaders = $httpRequest->headers;

                $headers['Access-Control-Allow-Credentials'] = 'true';
                $headers['Access-Control-Max-Age'] = '86400';

                if ($requestHeaders->has('Access-Control-Request-Headers')) {
                    $headers['Access-Control-Allow-Headers'] = $requestHeaders->get('Access-Control-Request-Headers');
                } else {
                    $headers['Access-Control-Allow-Headers'] = 'Origin, Content-Type';
                }
                if ($requestHeaders->has('Access-Control-Request-Method')) {
                    $headers['Access-Control-Allow-Methods'] = $requestHeaders->get('Access-Control-Request-Method');
                }
            }
        }
        $this->setResponseHeaders($headers);
    }
}
