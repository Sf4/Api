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

}
