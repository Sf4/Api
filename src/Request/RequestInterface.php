<?php

namespace Sf4\Api\Request;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Traits\DtoTraitInterface;
use Sf4\Api\RequestHandler\RequestHandlerTraitInterface;
use Sf4\Api\Response\ResponseInterface;
use Sf4\Api\Response\ResponseTraitInterface;
use Symfony\Component\HttpFoundation\Request;

interface RequestInterface extends ResponseTraitInterface, DtoTraitInterface, RequestHandlerTraitInterface
{
    public const ROUTE = '';

    /**
     * AbstractRequest constructor.
     * @param ResponseInterface $response
     * @param DtoInterface $dto
     */
    public function init(ResponseInterface $response, DtoInterface $dto);

    public function handle();

    /**
     * @return Request
     */
    public function getRequest(): ?Request;

    /**
     * @param Request|null $request
     */
    public function setRequest(?Request $request): void;

    /**
     * @return string
     */
    public function getRoute(): string;

    /**
     * @param \Closure $closure
     * @param string|null $cacheKey
     * @param array $tags
     * @param int $expiresAfter
     */
    public function getCachedResponse(
        \Closure $closure,
        string $cacheKey = null,
        array $tags = [],
        int $expiresAfter = null
    );
}
