<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:18
 */

namespace Sf4\Api\Dto\Traits;

use Sf4\Api\Dto\DtoInterface;

trait DtoTrait
{

    /** @var DtoInterface|null $dto */
    protected $dto;

    /**
     * @return DtoInterface|null
     */
    public function getDto(): ?DtoInterface
    {
        return $this->dto;
    }

    /**
     * @param DtoInterface|null $dto
     */
    public function setDto(?DtoInterface $dto): void
    {
        $this->dto = $dto;
    }
}
