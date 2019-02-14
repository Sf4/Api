<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 14.02.19
 * Time: 7:32
 */

namespace Sf4\Api\Event;

use Sf4\Api\Request\RequestInterface;
use Sf4\Api\Response\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

class RequestCreatedEvent extends Event
{
    const NAME = 'api.request.created';

    /** @var RequestInterface */
    protected $request;

    /** @var ResponseInterface|null $response */
    protected $response;

    /**
     * RequestCreatedEvent constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->setRequest($request);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface|null $response
     */
    public function setResponse(?ResponseInterface $response): void
    {
        $this->response = $response;
    }
}
