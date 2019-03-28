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
    protected $status;

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }
}
