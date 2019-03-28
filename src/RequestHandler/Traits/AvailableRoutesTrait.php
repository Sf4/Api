<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 4.02.19
 * Time: 11:09
 */

namespace Sf4\Api\RequestHandler\Traits;

trait AvailableRoutesTrait
{

    /** @var array $availableRoutes */
    protected $availableRoutes = [];

    /**
     * @return array
     */
    public function getAvailableRoutes(): array
    {
        return $this->availableRoutes;
    }

    /**
     * @param array $availableRoutes
     */
    public function setAvailableRoutes(array $availableRoutes): void
    {
        $this->availableRoutes = $availableRoutes;
    }

    /**
     * @param array $availableRoutes
     */
    public function addAvailableRoutes(array $availableRoutes): void
    {
        foreach ($availableRoutes as $route => $requestClass) {
            $this->addAvailableRoute($route, $requestClass);
        }
    }

    /**
     * @param string $route
     * @param string $requestClass
     */
    public function addAvailableRoute(string $route, string $requestClass): void
    {
        if (!in_array($route, $this->availableRoutes, true)) {
            $this->availableRoutes[$route] = $requestClass;
        }
    }
}
