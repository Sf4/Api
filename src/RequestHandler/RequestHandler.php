<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 7:48
 */

namespace Sf4\Api\RequestHandler;

use Sf4\Api\Dto\Response\ErrorDto;
use Sf4\Api\Request\OptionsRequest;
use Sf4\Api\Request\RequestInterface;
use Sf4\Api\Request\RequestTrait;
use Sf4\Api\RequestHandler\Traits\AvailableRoutesTrait;
use Sf4\Api\Utils\Traits\EntitymanagerTrait;
use Sf4\Api\Utils\Traits\TranslatorTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RequestHandler implements RequestHandlerInterface
{

    use RequestTrait;
    use TranslatorTrait;
    use EntitymanagerTrait;
    use AvailableRoutesTrait;

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        try {
            if ($request->getMethod() === 'OPTIONS') {
                $this->handleOptionsRequest($request);
            } else {
                $this->handleNormalRequest($request);
            }
        } catch (\Exception $exception) {
            $this->handleError($exception);
        }
    }

    /**
     * @param Request $request
     * @throws \ReflectionException
     */
    protected function handleOptionsRequest(Request $request)
    {
        $this->createRequestClass(OptionsRequest::class);
        $this->getRequest()->handle($request);
    }

    /**
     * @param string $requestClassName
     */
    protected function createRequestClass(string $requestClassName)
    {
        /** @var RequestInterface $request */
        $request = new $requestClassName();

        if ($request instanceof RequestInterface) {
            $this->setRequest($request);
            $request->setRequestHandler($this);
        }
    }

    /**
     * @param Request $request
     * @throws \ReflectionException
     */
    protected function handleNormalRequest(Request $request)
    {
        $routes = $this->getAvailableRoutes();
        $route = $request->attributes->get('_route');
        if (array_key_exists($route, $routes)) {
            $requestClassName = $routes[$route];
            $this->handleRequestClass($request, $requestClassName);
        }
    }

    /**
     * @param Request $request
     * @param string $requestClassName
     * @throws \ReflectionException
     */
    protected function handleRequestClass(Request $request, string $requestClassName)
    {
        $this->createRequestClass($requestClassName);
        $this->getRequest()->handle($request);
    }

    /**
     * @param \Exception $exception
     */
    protected function handleError(\Exception $exception)
    {
        $request = $this->getRequest();
        if ($request) {
            $response = $request->getResponse();
            if ($response) {
                $errorDto = new ErrorDto();
                $errorDto->error = $exception->getMessage();
                $response->setResponseDto($errorDto);
            }
        }
    }

    /**
     * @return JsonResponse|null
     */
    public function getResponse(): ?JsonResponse
    {
        $request = $this->getRequest();
        if ($request) {
            $response = $request->getResponse();
            if ($response) {
                return $response->getJsonResponse();
            }
        }

        return null;
    }
}
