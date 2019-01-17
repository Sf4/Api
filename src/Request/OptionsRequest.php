<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:02
 */

namespace Sf4\Api\Request;

use Sf4\Api\Dto\EmptyDto;
use Sf4\Api\Response\OptionsResponse;
use Sf4\Populator\PopulatorInterface;

class OptionsRequest extends AbstractRequest
{

    /**
     * OptionsRequest constructor.
     * @param OptionsResponse $response
     * @param EmptyDto $dto
     * @param PopulatorInterface $populator
     */
    public function __construct(OptionsResponse $response, EmptyDto $dto, PopulatorInterface $populator)
    {
        $this->init($response, $dto, $populator);
    }
}
