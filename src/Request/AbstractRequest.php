<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:03
 */

namespace Sf4\Api\Request;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Traits\DtoTrait;
use Sf4\Api\RequestHandler\RequestHandlerTrait;
use Sf4\Api\Response\ResponseInterface;
use Sf4\Api\Response\ResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest implements RequestInterface
{

    use ResponseTrait;
    use DtoTrait;
    use RequestHandlerTrait;

    /** @var Request|null $request */
    protected $request;

    /**
     * AbstractRequest constructor.
     * @param ResponseInterface $response
     * @param DtoInterface $dto
     */
    public function init(ResponseInterface $response, DtoInterface $dto = null)
    {
        $response->setRequest($this);
        $this->setResponse($response);
        if ($dto) {
            $this->setDto($dto);
            $this->attachDtoToResponse();
        }
    }

    protected function attachDtoToResponse()
    {
        $response = $this->getResponse();
        $dto = $this->getDto();
        if ($response !== null && $response->getDto() === null && $dto !== null) {
            $response->setDto($dto);
        }
    }

    /**
     * @param \Closure $closure
     * @param string|null $cacheKey
     * @param array $tags
     * @param int|null $expiresAfter
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getCachedResponse(
        \Closure $closure,
        string $cacheKey = null,
        array $tags = [],
        int $expiresAfter = null
    ) {
        if ($cacheKey) {
            $requestHandler = $this->getRequestHandler();

            $data = $requestHandler->getCacheDataOrAdd(
                $cacheKey,
                function () use ($closure, $requestHandler) {
                    $closure();
                    return $requestHandler->getResponse()->getContent();
                },
                $tags,
                $expiresAfter
            );

            $responseContent = json_decode($data, true);
            $this->getResponse()->setJsonResponse(
                new JsonResponse(
                    $responseContent,
                    $this->getResponse()->getResponseStatus(),
                    $this->getResponse()->getResponseHeaders()
                )
            );
        } else {
            /*
             * Handle request
             */
            $closure();
        }
    }

    /**
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function handle()
    {
        $this->getCachedResponse(
            function () {
                $requestContent = $this->getRequest()->getContent();
                if ($requestContent) {
                    $data = json_decode($requestContent, true);
                    $this->getDto()->populate($data);
                }
                $this->getResponse()->init();
            },
            $this->getCacheKey(),
            $this->getCacheTags(),
            $this->getCacheExpiresAfter()
        );
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @param Request|null $request
     */
    public function setRequest(?Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return static::ROUTE;
    }

    protected function getCacheKey(): ?string
    {
        return $this->getUrl();
    }

    abstract protected function getCacheTags(): array;

    protected function getCacheExpiresAfter(): ?int
    {
        return null;
    }

    protected function getUrl(): string
    {
        return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}
