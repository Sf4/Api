<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 7:48
 */

namespace Sf4\Api\RequestHandler;

use Sf4\Api\Request\OptionsRequest;
use Sf4\Api\Request\RequestInterface;
use Sf4\Api\Request\RequestTrait;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RequestHandler implements RequestHandlerInterface
{

    use ContainerAwareTrait;
    use RequestTrait;

    /** @var array $availableRoutes */
    protected $availableRoutes = [];

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
        $request = $this->container->get($requestClassName);

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
        $availableRoutes = $this->getAvailableRoutes();
        $route = $request->attributes->get('_route');
        if (array_key_exists($route, $availableRoutes)) {
            $requestClassName = $availableRoutes[$route];
            $this->handleRequestClass($request, $requestClassName);
        }
    }

    /**
     * @return array
     */
    protected function getAvailableRoutes(): array
    {
        return $this->availableRoutes;
    }

    /**
     * @param array $availableRoutes
     */
    public function setAvailableRoutes(array $availableRoutes)
    {
        $this->availableRoutes = $availableRoutes;
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
                $response->setData([
                    'error' => $exception->getMessage()
                ]);
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
