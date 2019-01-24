<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 24.01.19
 * Time: 8:33
 */

namespace Sf4\Api\Dto;

use Sf4\Populator\Populator;

class DtoPopulator
{
    /**
     * @param DtoInterface $dto
     * @param array $data
     */
    public function populate(DtoInterface $dto, array $data)
    {
        $populator = new Populator();
        try {
            $populator->populate($data, $dto);
        } catch (\ReflectionException $e) {
            $dto = new ErrorDto();
            $dto->error = $e->getMessage();
        }
    }
}
