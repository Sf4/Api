<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 24.01.19
 * Time: 16:01
 */

namespace Sf4\Api\Dto;

use Sf4\Api\Utils\Traits\SerializerTrait;

abstract class AbstractDto implements DtoInterface
{
    use SerializerTrait;
}
