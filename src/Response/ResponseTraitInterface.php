<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:45
 */

namespace Sf4\Api\Response;

interface ResponseTraitInterface
{
    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface;

    /**
     * @param ResponseInterface|null $response
     */
    public function setResponse(?ResponseInterface $response): void;
}
