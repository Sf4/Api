<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:48
 */

namespace Sf4\Api\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class OptionsResponse extends AbstractResponse
{

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse
    {
        $request = $this->getRequest()->getRequest();
        $response = parent::getJsonResponse();
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Headers', $request->headers->get('Access-Control-Request-Headers'));
        $response->headers->set('Access-Control-Allow-Methods', $request->headers->get('Access-Control-Request-Method'));

        return $response;
    }
}
