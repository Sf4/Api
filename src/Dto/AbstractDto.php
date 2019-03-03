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

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }
}
