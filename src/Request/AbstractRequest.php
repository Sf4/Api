<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 8:03
 */

namespace Sf4\Api\Request;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\DtoTrait;
use Sf4\Api\RequestHandler\RequestHandlerTrait;
use Sf4\Api\Response\ResponseInterface;
use Sf4\Api\Response\ResponseTrait;
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
     * @param Request $request
     * @throws \ReflectionException
     */
    public function handle(Request $request)
    {
        $this->setRequest($request);
        $this->getResponse()->init();
        $requestContent = $request->getContent();
        if ($requestContent) {
            $data = json_decode($requestContent);
            $this->getDto()->populate($data);
        }
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
}
