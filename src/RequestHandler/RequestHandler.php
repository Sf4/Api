<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 7:48
 */

namespace Sf4\Api\RequestHandler;

use Sf4\Api\Dto\Traits\CreateErrorDtoTrait;
use Sf4\Api\Event\RequestCreatedEvent;
use Sf4\Api\Exception\RequestNotCreatedException;
use Sf4\Api\Request\EmptyRequest;
use Sf4\Api\Request\OptionsRequest;
use Sf4\Api\Request\RequestInterface;
use Sf4\Api\Request\RequestTrait;
use Sf4\Api\RequestHandler\Traits\AvailableRoutesTrait;
use Sf4\Api\RequestHandler\Traits\CacheAdapterTrait;
use Sf4\Api\RequestHandler\Traits\EventDispatcherTrait;
use Sf4\Api\RequestHandler\Traits\ParameterBagTrait;
use Sf4\Api\RequestHandler\Traits\RepositoryFactoryTrait;
use Sf4\Api\RequestHandler\Traits\SitesTrait;
use Sf4\Api\Response\EmptyResponse;
use Sf4\Api\Utils\Traits\EntityManagerTrait;
use Sf4\Api\Utils\Traits\TranslatorTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RequestHandler implements RequestHandlerInterface
{

    use RequestTrait;
    use TranslatorTrait;
    use EntityManagerTrait;
    use AvailableRoutesTrait;
    use CreateErrorDtoTrait;
    use EventDispatcherTrait;
    use RepositoryFactoryTrait;
    use SitesTrait;
    use CacheAdapterTrait;
    use ParameterBagTrait;

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

    /**
     * @param Request $httpRequest
     */
    protected function handleOptionsRequest(Request $httpRequest): void
    {
        $this->createRequestClass(OptionsRequest::class);
        $request = $this->getRequest();
        if ($request) {
            $request->setRequest($httpRequest);
            $request->handle();
        }
    }

    /**
     * @param string $requestClassName
     */
    protected function createRequestClass(string $requestClassName): void
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
     */
    protected function handleNormalRequest(Request $request): void
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
     */
    protected function handleRequestClass(Request $request, string $requestClassName): void
    {
        $this->createRequestClass($requestClassName);

        if ($this->getRequest()) {
            $this->getRequest()->setRequest($request);

            $event = new RequestCreatedEvent($this->getRequest());
            $this->getDispatcher()->dispatch(RequestCreatedEvent::NAME, $event);

            if ($event->getResponse()) {
                $this->getRequest()->setResponse($event->getResponse());
            } else {
                $this->getRequest()->handle();
            }
        } else {
            $this->handleError(new RequestNotCreatedException());
        }
    }

    /**
     * @param \Exception $exception
     */
    protected function handleError(\Exception $exception): void
    {
        $request = $this->getRequest();

        if (!$request) {
            $request = new EmptyRequest();
        }

        $response = $request->getResponse();

        if (!$response) {
            $response = new EmptyResponse();
        }

        $errorDto = $this->createErrorDto($exception);
        $response->setResponseDto($errorDto);
    }
}
