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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getCachedResponse(\Closure $closure, string $cacheKey = null)
    {
        if ($cacheKey) {
            $cacheKey = md5($cacheKey);
            $cacheAdapter = $this->getRequestHandler()->getCacheAdapter();
            $cacheItem = $cacheAdapter->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                /*
                 * Return cached response
                 */
                $responseContent = json_decode($cacheItem->get(), true);
                $this->getResponse()->setJsonResponse(
                    new JsonResponse(
                        $responseContent,
                        $this->getResponse()->getResponseStatus(),
                        $this->getResponse()->getResponseHeaders()
                    )
                );
            } else {
                /*
                 * Handle request and add response to cache
                 */
                $closure();
                $responseContent = $this->getRequestHandler()->getResponse()->getContent();
                if ($responseContent) {
                    $cacheItem->set($responseContent);
                    $cacheItem->expiresAfter(0);
                    $cacheAdapter->save($cacheItem);
                }
            }
        } else {
            /*
             * Handle request
             */
            $closure();
        }
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function handle()
    {
        $this->getCachedResponse(function () {
            $requestContent = $this->getRequest()->getContent();
            if ($requestContent) {
                $data = json_decode($requestContent, true);
                $this->getDto()->populate($data);
            }
            $this->getResponse()->init();
        });
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
}
