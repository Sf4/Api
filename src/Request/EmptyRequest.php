<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 14.02.19
 * Time: 7:54
 */

namespace Sf4\Api\Request;

use Sf4\Api\Response\EmptyResponse;

class EmptyRequest extends AbstractRequest
{
    /**
     * EmptyRequest constructor.
     */
    public function __construct()
    {
        $this->init(
            new EmptyResponse()
        );
    }

    /**
     * @return array
     */
    protected function getCacheTags(): array
    {
        return [];
    }
}
