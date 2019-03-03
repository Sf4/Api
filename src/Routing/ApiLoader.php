<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 3.03.19
 * Time: 20:42
 */

namespace Sf4\Api\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class ApiLoader extends Loader
{
    const TYPE = 'sf4_api';

    /** @var bool $isLoaded */
    protected $isLoaded = false;

    /**
     * @param mixed $resource
     * @param null $type
     * @return RouteCollection|null
     */
    public function load($resource, $type = null)
    {
        if (true === $this->isLoaded) {
            return null;
        }

        $routes = new RouteCollection();

        $resource = '@Sf4ApiBundle/Resources/config/routing.yaml';
        $type = 'yaml';

        $importedRoutes = $this->import($resource, $type);
        $routes->addCollection($importedRoutes);

        $this->isLoaded = true;

        return $routes;
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return static::TYPE === $type;
    }
}
