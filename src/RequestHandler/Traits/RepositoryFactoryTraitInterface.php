<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:32
 */

namespace Sf4\Api\RequestHandler\Traits;

use Sf4\Api\Repository\RepositoryFactory;

interface RepositoryFactoryTraitInterface
{
    /**
     * @return RepositoryFactory
     */
    public function getRepositoryFactory(): RepositoryFactory;

    /**
     * @param RepositoryFactory $repositoryFactory
     */
    public function setRepositoryFactory(RepositoryFactory $repositoryFactory): void;
}
