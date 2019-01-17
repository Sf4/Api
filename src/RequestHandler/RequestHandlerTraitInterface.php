<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 16:17
 */

namespace Sf4\Api\RequestHandler;

interface RequestHandlerTraitInterface
{

    /**
     * @return RequestHandlerInterface|null
     */
    public function getRequestHandler(): ?RequestHandlerInterface;

    /**
     * @param RequestHandlerInterface|null $requestHandler
     */
    public function setRequestHandler(?RequestHandlerInterface $requestHandler): void;
}
