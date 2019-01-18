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
use Sf4\Populator\PopulatorInterface;

class DefaultRequest extends AbstractRequest
{
    const ROUTE = 'api_default';

    public function __construct(DefaultResponse $response, EmptyDto $dto, PopulatorInterface $populator)
    {
        $this->init($response, $dto, $populator);
    }
}
