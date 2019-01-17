<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:01
 */

namespace Sf4\Api\Dto;

interface DtoTraitInterface
{
    /**
     * @return DtoInterface|null
     */
    public function getDto(): ?DtoInterface;

    /**
     * @param DtoInterface|null $dto
     */
    public function setDto(?DtoInterface $dto): void;
}
