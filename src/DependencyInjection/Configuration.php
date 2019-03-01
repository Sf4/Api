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

    const NAME = 'sf4_api';
    const SITES = 'sites';
    const SITES_SITE = 'site';
    const SITES_URL = 'url';
    const SITES_TOKEN = 'token';
    const ROUTES = 'routes';
    const ROUTES_ROUTE = 'route';
    const ROUTES_REQUEST_CLASS = 'request_class';
    const ENTITIES = 'entities';
    const ENTITIES_TABLE_NAME = 'table_name';
    const ENTITIES_ENTITY_CLASS = 'entity_class';

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(static::NAME);

        $rootNode
            ->children()
                ->arrayNode(static::SITES)
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode(static::SITES_SITE)->end()
                            ->scalarNode(static::SITES_URL)->end()
                            ->scalarNode(static::SITES_TOKEN)->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode(static::ROUTES)
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode(static::ROUTES_ROUTE)->end()
                            ->scalarNode(static::ROUTES_REQUEST_CLASS)->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode(static::ENTITIES)
                    ->arrayPrototype()
                        ->children()
                        ->scalarNode(static::ENTITIES_TABLE_NAME)->end()
                        ->scalarNode(static::ENTITIES_ENTITY_CLASS)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
