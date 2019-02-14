<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 14.02.19
 * Time: 7:53
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\Response\MessageDto;

class EmptyResponse extends AbstractResponse
{

    public function init()
    {
        $this->setResponseDto(new MessageDto());
    }
}
