<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:34
 */

namespace Sf4\Api\RequestHandler\Traits;

interface AvailableRoutesTraitInterface
{
    /**
     * @return array
     */
    public function getAvailableRoutes(): array;

    /**
     * @param array $availableRoutes
     */
    public function setAvailableRoutes(array $availableRoutes);

    /**
     * @param array $availableRoutes
     */
    public function addAvailableRoutes(array $availableRoutes);

    /**
     * @param string $route
     * @param string $requestClass
     */
    public function addAvailableRoute(string $route, string $requestClass);
}
