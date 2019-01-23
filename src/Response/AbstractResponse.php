<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:19
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoTrait;
use Sf4\Api\Repository\AbstractRepository;
use Sf4\Api\Request\RequestTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse implements ResponseInterface
{

    use DtoTrait;
    use RequestTrait;

    /** @var array $responseData */
    protected $responseData;

    /** @var int $responseStatus */
    protected $responseStatus;

    /** @var array $responseHeaders */
    protected $responseHeaders;

    public function __construct()
    {
        $this->createJsonResponse([], 200, static::HEADERS);
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     */
    protected function createJsonResponse(array $data, int $status = 200, array $headers = self::HEADERS)
    {
        $this->setResponseData($data);
        $this->setResponseStatus($status);
        $this->setResponseHeaders($headers);
    }

    public abstract function init();

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse
    {
        $response = new JsonResponse(
            $this->getResponseData(),
            $this->getResponseStatus(),
            $this->getResponseHeaders()
        );
        $request = $this->getRequest()->getRequest();
        $response->headers->set(
            'Access-Control-Allow-Origin',
            $request->headers->get('Origin')
        );
        return $response;
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * @param array $responseData
     */
    public function setResponseData(array $responseData): void
    {
        $this->responseData = $responseData;
    }

    /**
     * @return int
     */
    public function getResponseStatus(): int
    {
        return $this->responseStatus;
    }

    /**
     * @param int $responseStatus
     */
    public function setResponseStatus($responseStatus): void
    {
        $this->responseStatus = $responseStatus;
    }

    /**
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * @param array $responseHeaders
     */
    public function setResponseHeaders(array $responseHeaders): void
    {
        $this->responseHeaders = $responseHeaders;
    }

    /**
     * @param string $entityClass
     * @return AbstractRepository|null
     */
    public function getRepository(string $entityClass): ?AbstractRepository
    {
        $request = $this->getRequest();
        if(!$request) {
            return null;
        }
        $requestHandler = $request->getRequestHandler();
        $manager = $requestHandler->getEntityManager();

        $repository = $manager->getRepository($entityClass);
        if($repository instanceof AbstractRepository) {
            return $repository;
        }

        return null;
    }
}
