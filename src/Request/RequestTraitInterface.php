<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:10
 */

namespace Sf4\Api\Request;

interface RequestTraitInterface
{

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface;

    /**
     * @param RequestInterface|null $request
     */
    public function setRequest(?RequestInterface $request): void;
}
