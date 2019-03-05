<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:35
 */

namespace Sf4\Api\RequestHandler\Traits;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherTraitInterface
{
    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher(): EventDispatcherInterface;

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): void;
}
