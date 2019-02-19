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
        $dto->setAvailableRoutes(
            $this->getRequest()->getRequestHandler()->getAvailableRoutes()
        );
        $this->setResponseDto($dto);
    }
}
