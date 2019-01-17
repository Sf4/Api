<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 16:16
 */

namespace Sf4\Api\RequestHandler;

trait RequestHandlerTrait
{

    /** @var RequestHandlerInterface|null $requestHandler */
    protected $requestHandler;

    /**
     * @return RequestHandlerInterface|null
     */
    public function getRequestHandler(): ?RequestHandlerInterface
    {
        return $this->requestHandler;
    }

    /**
     * @param RequestHandlerInterface|null $requestHandler
     */
    public function setRequestHandler(?RequestHandlerInterface $requestHandler): void
    {
        $this->requestHandler = $requestHandler;
    }
}
