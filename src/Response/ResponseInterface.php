<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:05
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoTraitInterface;
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
     * @return array
     */
    public function getData(): array;

    /**
     * @param array $data
     */
    public function setData(array $data): void;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     */
    public function setStatus($status): void;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void;

    public function init();
}
