<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 14.02.19
 * Time: 7:32
 */

namespace Sf4\Api\Event;

use Sf4\Api\Request\RequestInterface;
use Sf4\Api\Request\RequestTrait;
use Sf4\Api\Response\ResponseTrait;
use Symfony\Component\EventDispatcher\Event;

class RequestCreatedEvent extends Event
{
    use RequestTrait;
    use ResponseTrait;

    public const NAME = 'api.request.created';

    /**
     * RequestCreatedEvent constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->setRequest($request);
    }
}
