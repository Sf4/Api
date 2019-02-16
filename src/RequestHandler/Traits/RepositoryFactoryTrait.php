<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 16.02.19
 * Time: 19:55
 */

namespace Sf4\Api\RequestHandler\Traits;

use Sf4\Api\Repository\RepositoryFactory;

trait RepositoryFactoryTrait
{

    /** @var RepositoryFactory $repositoryFactory */
    protected $repositoryFactory;

    /**
     * @return RepositoryFactory
     */
    public function getRepositoryFactory(): RepositoryFactory
    {
        return $this->repositoryFactory;
    }

    /**
     * @param RepositoryFactory $repositoryFactory
     */
    public function setRepositoryFactory(RepositoryFactory $repositoryFactory): void
    {
        $this->repositoryFactory = $repositoryFactory;
    }
}
