<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 24.01.19
 * Time: 16:01
 */

namespace Sf4\Api\Dto;

use Sf4\Populator\Populator;

abstract class AbstractDto implements DtoInterface
{

    private $populator;

    public function __construct()
    {
        $this->setPopulator(new Populator());
    }

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    public function populate(array $data): void
    {
        $this->getPopulator()->populate($data, $this);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getPopulator()->unpopulate($this);
    }

    /**
     * @return Populator
     */
    protected function getPopulator(): Populator
    {
        return $this->populator;
    }

    /**
     * @param Populator $populator
     */
    protected function setPopulator(Populator $populator): void
    {
        $this->populator = $populator;
    }
}
