<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 26.02.19
 * Time: 10:01
 */

namespace Sf4\Api\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public const NAME = 'sf4_api';
    public const SITES = 'sites';
    public const SITES_SITE = 'site';
    public const SITES_URL = 'url';
    public const SITES_TOKEN = 'token';
    public const ROUTES = 'routes';
    public const ROUTES_ROUTE = 'route';
    public const ROUTES_REQUEST_CLASS = 'request_class';
    public const ENTITIES = 'entities';
    public const ENTITIES_TABLE_NAME = 'table_name';
    public const ENTITIES_ENTITY_CLASS = 'entity_class';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(static::NAME);

        $children = $rootNode->children();

        $sites = $children->arrayNode(static::SITES)->arrayPrototype()->children();
        $sites->scalarNode(static::SITES_SITE)->end();
        $sites->scalarNode(static::SITES_URL)->end();
        $sites->scalarNode(static::SITES_TOKEN)->end();
        $sites->end()->end();
        $sites->end();

        $routes = $children->arrayNode(static::ROUTES)->arrayPrototype()->children();
        $routes->scalarNode(static::ROUTES_ROUTE)->end();
        $routes->scalarNode(static::ROUTES_REQUEST_CLASS)->end();
        $routes->end()->end();
        $routes->end();

        $entities = $children->arrayNode(static::ENTITIES)->arrayPrototype()->children();
        $entities->scalarNode(static::ENTITIES_TABLE_NAME)->end();
        $entities->scalarNode(static::ENTITIES_ENTITY_CLASS)->end();
        $entities->end()->end();
        $entities->end();

        $children->end();

        return $treeBuilder;
    }
}
