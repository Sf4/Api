<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 9:10
 */

namespace Sf4\Api\Request;

use Sf4\Api\Dto\EmptyDto;
use Sf4\Api\Response\DefaultResponse;
use Sf4\Populator\Populator;
use Sf4\Populator\PopulatorInterface;

class DefaultRequest extends AbstractRequest
{
    const ROUTE = 'api_default';

    public function __construct()
    {
        $response = new DefaultResponse();
        $dto = new EmptyDto();
        $populator = new Populator();
        $this->init($response, $dto, $populator);
    }
}
