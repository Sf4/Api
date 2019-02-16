<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 16.02.19
 * Time: 19:28
 */

namespace Sf4\Api\Repository;

use Doctrine\ORM\EntityManagerInterface;

class RepositoryFactory
{

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /** @var array $entities */
    protected $entities;

    /**
     * RepositoryFactory constructor.
     * @param EntityManagerInterface $entityManager
     * @param array $entities
     */
    public function __construct(EntityManagerInterface $entityManager, array $entities)
    {
        $this->entityManager = $entityManager;
        $this->entities = $entities;
    }

    /**
     * @param string $tableName
     * @return RepositoryInterface|null
     */
    public function create(string $tableName): ?RepositoryInterface
    {
        if (isset($this->entities[$tableName])) {
            $entityClass = $this->entities[$tableName];
            $repository = $this->entityManager->getRepository($entityClass);

            if ($repository instanceof RepositoryInterface) {
                return $repository;
            }
        }

        return null;
    }
}
