<?php

namespace Sf4\Api\EventSubscriber;

use Sf4\Api\RequestHandler\RequestHandlerInterface;
use Sf4\Api\RequestHandler\RequestHandlerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    use RequestHandlerTrait;

    /**
     * RequestSubscriber constructor.
     * @param RequestHandlerInterface $requestHandler
     */
    public function __construct(RequestHandlerInterface $requestHandler)
    {
        $this->setRequestHandler($requestHandler);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'handleRequest',
            KernelEvents::EXCEPTION => 'handleException'
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handleRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if ($request->attributes->has('_route')) {
            $requestHandler = $this->getRequestHandler();
            if ($requestHandler) {
                $requestHandler->handle($request);
                if ($response = $requestHandler->getResponse()) {
                    $event->setResponse($response);
                }
            }
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function handleException(GetResponseForExceptionEvent $event): void
    {
        $event->setResponse(new JsonResponse([
            $event->getException()->getMessage()
        ], 200));
    }
}
