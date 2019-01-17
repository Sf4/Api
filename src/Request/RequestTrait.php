<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:09
 */

namespace Sf4\Api\Request;

trait RequestTrait
{

    /** @var RequestInterface|null $request */
    protected $request;

    /**
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface|null $request
     */
    public function setRequest(?RequestInterface $request): void
    {
        $this->request = $request;
    }
}
