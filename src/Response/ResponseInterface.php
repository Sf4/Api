<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:05
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Traits\DtoTraitInterface;
use Sf4\Api\Request\RequestTraitInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

interface ResponseInterface extends DtoTraitInterface, RequestTraitInterface
{
    const HEADERS = [
        'accept' => 'application/json',
        'Content-Type' => 'application/json'
    ];

    /**
     * @return JsonResponse
     */
    public function getJsonResponse(): JsonResponse;

    /**
     * @return DtoInterface
     */
    public function getResponseDto(): DtoInterface;

    /**
     * @param DtoInterface $data
     */
    public function setResponseDto(DtoInterface $data): void;

    /**
     * @return int
     */
    public function getResponseStatus(): int;

    /**
     * @param int $status
     */
    public function setResponseStatus($status): void;

    /**
     * @return array
     */
    public function getResponseHeaders(): array;

    /**
     * @param array $headers
     */
    public function setResponseHeaders(array $headers): void;

    public function init();
}
