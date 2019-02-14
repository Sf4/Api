<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 8:27
 */

namespace Sf4\Api\Dto\Traits;

use Sf4\Api\Dto\Response\ErrorDto;

trait CreateErrorDtoTrait
{
    protected function createErrorDto(\Exception $exception)
    {
        $errorDto = new ErrorDto();
        $errorDto->error = $exception->getMessage();

        return $errorDto;
    }
}
