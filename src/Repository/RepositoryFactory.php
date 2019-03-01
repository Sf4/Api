<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 16.02.19
 * Time: 19:28
 */

namespace Sf4\Api\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Sf4\Api\Utils\Traits\EntityManagerTrait;

class RepositoryFactory
{

    use EntityManagerTrait;

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /** @var array $entities */
    protected $entities;

    /**
     * RepositoryFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param array $entities
     */
    public function __construct(EntityManagerInterface $entityManager, array $entities = [])
    {
        $this->setEntityManager($entityManager);
        $this->entities = $entities;
    }

    /**
     * @param array $entities
     */
    public function addEntities(array $entities)
    {
        foreach ($entities as $tableName => $entityClass) {
            $this->addEntity($tableName, $entityClass);
        }
    }

    /**
     * @param string $tableName
     * @param string $entityClass
     */
    public function addEntity(string $tableName, string $entityClass)
    {
        $this->entities[$tableName] = $entityClass;
    }

    /**
     * @param string $tableName
     * @return RepositoryInterface|null
     */
    public function create(string $tableName): ?RepositoryInterface
    {
        $entityClass = $this->getEntityClass($tableName);
        if ($entityClass) {
            $repository = $this->getEntityManager()->getRepository($entityClass);
            if ($repository instanceof RepositoryInterface) {
                return $repository;
            }
        }

        return null;
    }

    /**
     * @param string $tableName
     * @return string|null
     */
    public function getEntityClass(string $tableName): ?string
    {
        if (isset($this->entities[$tableName])) {
            return $this->entities[$tableName];
        }

        return null;
    }
}
