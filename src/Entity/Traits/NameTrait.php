<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 15.02.19
 * Time: 9:03
 */

namespace Sf4\Api\Entity\Traits;

trait NameTrait
{
    /** @var string|null $name */
    protected $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
