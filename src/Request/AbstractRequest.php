<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:03
 */

namespace Sf4\Api\Request;

use Closure;
use Psr\Cache\CacheException;
use Psr\Cache\InvalidArgumentException;
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

    protected function attachDtoToResponse(): void
    {
        $response = $this->getResponse();
        $dto = $this->getDto();
        if (null !== $dto && null !== $response && null === $response->getDto()) {
            $response->setDto($dto);
        }
    }

    /**
     * @param Closure $closure
     * @param string|null $cacheKey
     * @param array $tags
     * @param int|null $expiresAfter
     * @throws CacheException
     * @throws InvalidArgumentException
     */
    public function getCachedResponse(
        Closure $closure,
        string $cacheKey = null,
        array $tags = [],
        int $expiresAfter = null
    ) {

        $requestHandler = $this->getRequestHandler();
        if ($cacheKey && $requestHandler && $jsonResponse = $requestHandler->getResponse()) {
            $data = $requestHandler->getCacheDataOrAdd(
                $cacheKey,
                static function () use ($closure, $jsonResponse) {
                    $closure();
                    return $jsonResponse->getContent();
                },
                $tags,
                $expiresAfter
            );

            $responseContent = json_decode($data, true);
            $response = $this->getResponse();
            if ($response) {
                $response->setJsonResponse(
                    new JsonResponse(
                        $responseContent,
                        $response->getResponseStatus(),
                        $response->getResponseHeaders()
                    )
                );
            }
        } else {
            /*
             * Handle request
             */
            $closure();
        }
    }

    /**
     * @throws CacheException
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        $response = $this->getResponse();
        $requestHandler = $this->getRequestHandler();
        if ($response && $requestHandler && $translator = $requestHandler->getTranslator()) {
            $response->setTranslator($translator);
        }
        $this->getCachedResponse(
            function () use ($response) {
                $httpRequest = $this->getRequest();
                if ($httpRequest) {
                    $requestContent = $httpRequest->getContent();
                    $dto = $this->getDto();
                    if ($requestContent && $dto) {
                        $data = json_decode($requestContent, true);
                        $dto->populate($data);
                    }
                }
                if ($response) {
                    $response->init();
                }
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

    /**
     * @return string|null
     */
    protected function getCacheKey(): ?string
    {
        return $this->getUrl();
    }

    /**
     * @return array
     */
    abstract protected function getCacheTags(): array;

    /**
     * @return int|null
     */
    protected function getCacheExpiresAfter(): ?int
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getUrl(): string
    {
        return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}
