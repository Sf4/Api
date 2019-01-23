<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 9:11
 */

namespace Sf4\Api\Response;

class DefaultResponse extends AbstractResponse
{
    public function init()
    {
        $this->setResponseData([
            'message' => 'Default'
        ]);
    }
}
