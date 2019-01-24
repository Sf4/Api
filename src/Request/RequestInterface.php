<?php

namespace Sf4\Api\Request;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\DtoTraitInterface;
use Sf4\Api\RequestHandler\RequestHandlerTraitInterface;
use Sf4\Api\Response\ResponseInterface;
use Sf4\Api\Response\ResponseTraitInterface;
use Symfony\Component\HttpFoundation\Request;

interface RequestInterface extends ResponseTraitInterface, DtoTraitInterface, RequestHandlerTraitInterface
{
    const ROUTE = '';

    /**
     * AbstractRequest constructor.
     * @param ResponseInterface $response
     * @param DtoInterface $dto
     */
    public function init(ResponseInterface $response, DtoInterface $dto);

    /**
     * @param Request $request
     * @throws \ReflectionException
     */
    public function handle(Request $request);

    /**
     * @return Request
     */
    public function getRequest(): ?Request;

    /**
     * @param Request|null $request
     */
    public function setRequest(?Request $request): void;
}
