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
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AbstractResponse implements ResponseInterface
{

    use DtoTrait;
    use RequestTrait;
    use CreateErrorDtoTrait;

    /** @var DtoInterface $responseDto */
    protected $responseDto;

    /** @var int $responseStatus */
    protected $responseStatus;

    /** @var array $responseHeaders */
    protected $responseHeaders;

    public function __construct()
    {
        $this->createJsonResponse(new EmptyDto(), 200, static::HEADERS);
    }

    /**
     * @param DtoInterface $data
     * @param int $status
     * @param array $headers
     */
    protected function createJsonResponse(DtoInterface $data, int $status = 200, array $headers = self::HEADERS)
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
        $response = new JsonResponse(
            $this->getResponseDto()->toArray(),
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

        $repositoryFactory = $requestHandler->getRepositoryFactory();
        return $repositoryFactory->create($tableName);
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function translate($id, array $parameters = array(), $domain = null, $locale = null)
    {
        $translator = $this->getRequest()->getRequestHandler()->getTranslator();

        return $translator->trans($id, $parameters, $domain, $locale);
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
