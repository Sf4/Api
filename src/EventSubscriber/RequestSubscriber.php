<?php

namespace Sf4\Api\EventSubscriber;

use Sf4\Api\RequestHandler\RequestHandlerInterface;
use Sf4\Api\RequestHandler\RequestHandlerTrait;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    use RequestHandlerTrait;
    use ContainerAwareTrait;

    /** @var RequestHandlerInterface $requestHandler */
    protected $requestHandler;

    /**
     * RequestSubscriber constructor.
     * @param RequestHandlerInterface $requestHandler
     * @param ContainerInterface $container
     */
    public function __construct(RequestHandlerInterface $requestHandler, ContainerInterface $container)
    {
        $requestHandler->setContainer($container);
        $this->setRequestHandler($requestHandler);
        $this->setContainer($container);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'handleRequest',
            KernelEvents::EXCEPTION => 'handleException'
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handleRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->attributes->has('_route')) {
            $this->getRequestHandler()->handle($request);
            if ($response = $this->getRequestHandler()->getResponse()) {
                $event->setResponse($response);
            }
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function handleException(GetResponseForExceptionEvent $event)
    {
        $event->setResponse(new JsonResponse([
            $event->getException()->getMessage()
        ], 200));
    }
}
