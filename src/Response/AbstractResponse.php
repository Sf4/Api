<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 9:19
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Response\EmptyDto;
use Sf4\Api\Dto\Traits\CreateErrorDtoTrait;
use Sf4\Api\Dto\Traits\DtoTrait;
use Sf4\Api\Repository\AbstractRepository;
use Sf4\Api\Repository\RepositoryInterface;
use Sf4\Api\Request\RequestTrait;
use Sf4\Api\Utils\Traits\TranslatorTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse implements ResponseInterface
{

    use DtoTrait;
    use RequestTrait;
    use CreateErrorDtoTrait;
    use TranslatorTrait;

    /** @var DtoInterface $responseDto */
    protected $responseDto;

    /** @var int $responseStatus */
    protected $responseStatus;

    /** @var array $responseHeaders */
    protected $responseHeaders;

    /** @var JsonResponse $jsonResponse */
    protected $jsonResponse;

    public function __construct()
    {
        $request = $this->getRequest();
        if ($request) {
            $requestHandler = $request->getRequestHandler();
            if ($requestHandler) {
                $translator = $requestHandler->getTranslator();
                $this->setTranslator($translator);
            }
        }
        $this->createJsonResponse(new EmptyDto(), 200, static::HEADERS);
    }

    /**
     * @param DtoInterface $data
     * @param int $status
     * @param array $headers
     */
    protected function createJsonResponse(DtoInterface $data, int $status = 200, array $headers = self::HEADERS): void
    {
        $this->setResponseDto($data);
        $this->setResponseStatus($status);
        $this->setResponseHeaders($headers);
    }

    abstract public function init();

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse
    {
        if (!$this->jsonResponse) {
            $response = new JsonResponse(
                $this->getResponseDto()->toArray(),
                $this->getResponseStatus(),
                $this->getResponseHeaders()
            );
        } else {
            $response = $this->jsonResponse;
        }
        $request = $this->getRequest();
        if ($request) {
            $httpRequest = $request->getRequest();
            if ($httpRequest) {
                $response->headers->set(
                    'Access-Control-Allow-Origin',
                    $httpRequest->headers->get('Origin')
                );
            }
        }
        return $response;
    }

    /**
     * @param JsonResponse $jsonResponse
     */
    public function setJsonResponse(JsonResponse $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @return DtoInterface
     */
    public function getResponseDto(): DtoInterface
    {
        return $this->responseDto;
    }

    /**
     * @param DtoInterface $responseDto
     */
    public function setResponseDto(DtoInterface $responseDto): void
    {
        $this->responseDto = $responseDto;
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
     * @param string $tableName
     * @return AbstractRepository|null
     */
    public function getRepository(string $tableName): ?RepositoryInterface
    {
        $request = $this->getRequest();
        if (!$request) {
            return null;
        }
        $requestHandler = $request->getRequestHandler();
        if ($requestHandler) {
            $repositoryFactory = $requestHandler->getRepositoryFactory();
            return $repositoryFactory->create($tableName);
        }

        return null;
    }

    /**
     * @param DtoInterface $dto
     * @param array $data |null
     * @return DtoInterface|\Sf4\Api\Dto\Response\ErrorDto
     */
    protected function populateDto(DtoInterface $dto, ?array $data)
    {
        if ($data) {
            try {
                $dto->populate($data);
            } catch (\ReflectionException $e) {
                $dto = $this->createErrorDto($e);
            }
        }
        return $dto;
    }
}
