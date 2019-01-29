<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 27.01.19
 * Time: 16:58
 */

namespace Sf4\Api\Dto\Filter;

use Sf4\Api\Dto\DtoInterface;

interface FilterInterface extends DtoInterface
{
    /**
     * @param array|object|null $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void;

    /**
     * @return array
     */
    public function toArray(): array;
}
