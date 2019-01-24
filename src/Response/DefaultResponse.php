<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 9:11
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\MessageDto;

class DefaultResponse extends AbstractResponse
{
    public function init()
    {
        $messageDto = new MessageDto();
        $messageDto->message = 'Default view';
        $this->setResponseDto($messageDto);
    }
}
