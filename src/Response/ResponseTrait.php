<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:16
 */

namespace Sf4\Api\Response;

trait ResponseTrait
{

    /** @var ResponseInterface|null $response */
    protected $response;

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface|null $response
     */
    public function setResponse(?ResponseInterface $response): void
    {
        $this->response = $response;
    }
}
