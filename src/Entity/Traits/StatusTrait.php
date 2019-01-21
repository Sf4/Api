<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 21.01.19
 * Time: 8:44
 */

namespace Sf4\Api\Entity\Traits;

trait StatusTrait
{

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return StatusTrait
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
