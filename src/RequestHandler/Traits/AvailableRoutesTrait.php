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
    public function setAvailableRoutes(array $availableRoutes)
    {
        $this->availableRoutes = $availableRoutes;
    }

    /**
     * @param array $availableRoutes
     */
    public function addAvailableRoutes(array $availableRoutes)
    {
        foreach ($availableRoutes as $route => $requestClass) {
            $this->addAvailableRoute($route, $requestClass);
        }
    }

    /**
     * @param string $route
     * @param string $requestClass
     */
    public function addAvailableRoute(string $route, string $requestClass)
    {
        if (!in_array($route, $this->availableRoutes)) {
            $this->availableRoutes[$route] = $requestClass;
        }
    }
}
