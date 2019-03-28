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

    /** @var array $entities */
    protected $entities;

    /** @var array $repositories */
    protected $repositories = [];

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
    public function addEntities(array $entities): void
    {
        foreach ($entities as $tableName => $entityClass) {
            $this->addEntity($tableName, $entityClass);
        }
    }

    /**
     * @param string $tableName
     * @param string $entityClass
     */
    public function addEntity(string $tableName, string $entityClass): void
    {
        $this->entities[$tableName] = $entityClass;
    }

    /**
     * @param string $tableName
     * @return RepositoryInterface|null
     */
    public function create(string $tableName): ?RepositoryInterface
    {
        if (array_key_exists($tableName, $this->repositories)) {
            return $this->repositories[$tableName];
        }

        $entityClass = $this->getEntityClass($tableName);
        if ($entityClass) {
            $repository = $this->getEntityManager()->getRepository($entityClass);
            if ($repository instanceof RepositoryInterface) {
                $this->repositories[$tableName] = $repository;
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
        return $this->entities[$tableName] ?? null;
    }
}
