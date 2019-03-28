<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 19.02.19
 * Time: 7:12
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\Response\SiteResponseDto;

class SiteResponse extends AbstractResponse
{

    public function init()
    {
        $dto = new SiteResponseDto();
        $request = $this->getRequest();
        if ($request) {
            $requestHandler = $request->getRequestHandler();
            if ($requestHandler) {
                $dto->setAvailableRoutes(
                    $requestHandler->getAvailableRoutes()
                );
            }
        }
        $this->setResponseDto($dto);
    }
}
