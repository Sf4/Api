<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 25.02.19
 * Time: 9:45
 */

namespace Sf4\Api\DependencyInjection;

use Sf4\Api\DependencyInjection\Traits\Sf4ApiExtensionTrait;
use Sf4\Api\Request\DefaultRequest;
use Sf4\Api\Request\SiteRequest;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class Sf4ApiExtension extends Extension
{

    use Sf4ApiExtensionTrait;


    /**
     * Loads a specific configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->loadServices($container, __DIR__);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->addRequestHandlerDefaultSites($container);
        if (array_key_exists(Configuration::SITES, $config) && !empty($config[Configuration::SITES])) {
            $this->addRequestHandlerSites($container, $config[Configuration::SITES]);
        }

        $this->addRequestHandlerDefaultRoutes($container);
        if (array_key_exists(Configuration::ROUTES, $config) && !empty($config[Configuration::ROUTES])) {
            $this->addRequestHandlerRoutes($container, $config[Configuration::ROUTES]);
        }

        if (array_key_exists(Configuration::ENTITIES, $config) && !empty($config[Configuration::ENTITIES])) {
            $this->addRepositoryFactoryEntities($container, $config[Configuration::ENTITIES]);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function addRequestHandlerDefaultSites(ContainerBuilder $container): void
    {
        $this->addRequestHandlerSites($container, [
            [
                Configuration::SITES_SITE => 'parent',
                Configuration::SITES_URL => null,
                Configuration::SITES_TOKEN => null
            ]
        ]);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function addRequestHandlerDefaultRoutes(ContainerBuilder $container): void
    {
        $this->addRequestHandlerRoutes($container, [
            [
                Configuration::ROUTES_ROUTE => DefaultRequest::ROUTE,
                Configuration::ROUTES_REQUEST_CLASS => DefaultRequest::class
            ],
            [
                Configuration::ROUTES_ROUTE => SiteRequest::ROUTE,
                Configuration::ROUTES_REQUEST_CLASS => SiteRequest::class
            ]
        ]);
    }
}
