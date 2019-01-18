<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:19
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoTrait;
use Sf4\Api\Request\RequestTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse implements ResponseInterface
{

    use DtoTrait;
    use RequestTrait;

    /** @var array $data */
    protected $data;

    /** @var int $status */
    protected $status;

    /** @var array $headers */
    protected $headers;

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
        $this->setData($data);
        $this->setStatus($status);
        $this->setHeaders($headers);
    }

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse
    {
        $response = new JsonResponse(
            $this->getData(),
            $this->getStatus(),
            $this->getHeaders()
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
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }
}
