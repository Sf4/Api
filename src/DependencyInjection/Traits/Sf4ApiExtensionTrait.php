<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 28.02.19
 * Time: 8:47
 */

namespace Sf4\Api\DependencyInjection\Traits;

use Sf4\Api\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Sf4\Api\Repository\RepositoryFactory;
use Sf4\Api\RequestHandler\RequestHandlerInterface;

trait Sf4ApiExtensionTrait
{

    /**
     * @param ContainerBuilder $container
     * @param string $dir
     * @throws \Exception
     */
    protected function loadServices(ContainerBuilder $container, string $dir)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator($dir.'/../Resources/config')
        );
        $loader->load('services.yaml');
    }

    /**
     * @param ContainerBuilder $container
     * @param array $configSites
     */
    protected function addRequestHandlerSites(ContainerBuilder $container, array $configSites)
    {
        $definition = $container->getDefinition(RequestHandlerInterface::class);
        $definition->addMethodCall(
            'addSites',
            [
                '$sites' => $configSites
            ]
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array $configRoutes
     */
    protected function addRequestHandlerRoutes(ContainerBuilder $container, array $configRoutes)
    {
        $availableRoutes = [];
        foreach ($configRoutes as $route) {
            $availableRoutes[$route[Configuration::ROUTES_ROUTE]] = $route[Configuration::ROUTES_REQUEST_CLASS];
        }

        $definition = $container->getDefinition(RequestHandlerInterface::class);
        $definition->addMethodCall(
            'addAvailableRoutes',
            [
                '$availableRoutes' => $availableRoutes
            ]
        );
    }

    /**
     * @param ContainerBuilder $container
     * @param array $configEntities
     */
    protected function addRepositoryFactoryEntities(ContainerBuilder $container, array $configEntities)
    {
        $definition = $container->getDefinition(RepositoryFactory::class);
        foreach ($configEntities as $entity) {
            $tableName = $entity[Configuration::ENTITIES_TABLE_NAME];
            $entityClass = $entity[Configuration::ENTITIES_ENTITY_CLASS];
            $definition->addMethodCall(
                'addEntity',
                [
                    '$tableName' => $tableName,
                    '$entityClass' => $entityClass
                ]
            );
        }
    }
}
