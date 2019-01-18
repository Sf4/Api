<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:02
 */

namespace Sf4\Api\Request;

use Sf4\Api\Response\OptionsResponse;

class OptionsRequest extends AbstractRequest
{

    /**
     * OptionsRequest constructor.
     */
    public function __construct()
    {
        $this->init(
            new OptionsResponse()
        );
    }
}
