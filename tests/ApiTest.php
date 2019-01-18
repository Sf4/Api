<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 19:06
 */

namespace Sf4\Api;

use Sf4\Api\Request\DefaultRequest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sf4\Api\EventSubscriber\RequestSubscriber;
use Sf4\Api\RequestHandler\RequestHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ApiTest extends WebTestCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $_SERVER['KERNEL_CLASS'] = TestKernel::class;
        self::createKernel();
        self::bootKernel();
    }

    public function testOptionsRequest()
    {
        $this->_testDefaultRoute(Request::METHOD_OPTIONS);
    }

    public function testDefaultRequest()
    {
        $this->_testDefaultRoute(Request::METHOD_GET);
    }

    protected function _testDefaultRoute(string $requestMethod)
    {
        $request = new Request();
        $request->attributes->set('_route', 'api_default');
        $request->setMethod($requestMethod);
        $response = $this->createEventAndReturnResponse($request);
        $responseStatusCode = $response->getStatusCode();
        $this->assertTrue($responseStatusCode === Response::HTTP_OK );
    }

    protected function handleRequest(GetResponseEvent $event)
    {
        $requestHandler = new RequestHandler();
        $requestHandler->setAvailableRoutes([
            'api_default' => DefaultRequest::class
        ]);
        $requestSubscriber = new RequestSubscriber($requestHandler);
        $requestSubscriber->handleRequest($event);
    }

    protected function createEventAndReturnResponse(Request $request): ?Response
    {
        $event = new GetResponseEvent(
            self::$kernel,
            $request,
            HttpKernelInterface::MASTER_REQUEST
        );
        $this->handleRequest($event);
        return $event->getResponse();
    }
}
