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
        $headers = $this->getHeaders();
        if ($request) {
            $httpRequest = $request->getRequest();
            $requestHeaders = $httpRequest->headers;
            $headers['Access-Control-Allow-Credentials'] = 'true';
            if ($requestHeaders->has('Access-Control-Request-Headers')) {
                $headers['Access-Control-Allow-Headers'] = $requestHeaders->get('Access-Control-Request-Headers');
            }
            if ($requestHeaders->has('Access-Control-Request-Method')) {
                $headers['Access-Control-Allow-Methods'] = $requestHeaders->get('Access-Control-Request-Method');
            }
        }
        $this->setHeaders($headers);
    }
}
