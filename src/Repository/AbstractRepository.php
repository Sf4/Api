<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 21.01.19
 * Time: 8:26
 */

namespace Sf4\Api\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Sf4\Api\Exception\InvalidObjectTypeException;

abstract class AbstractRepository extends EntityRepository
{
    const TABLE_NAME = null;

    /**
     * @param $id
     * @return array|null
     * @throws \Exception
     */
    public function findDataById($id): ?array
    {
        $this->throwExceptionWhenDbNameIsNull();
        $qb = $this->createQueryBuilder('main');
        $qb->where(
            $qb->expr()->eq('main.id', ':id')
        );
        $qb->setParameter(':id', $id);

        $results = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
        if($results) {
            return $results[0];
        }
        return null;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function findOneOrNullData(string $sql, array $params = []): ?array
    {
        $statement = $this->getStatement($sql, $params);
        if ($statement) {
            $data = $statement->fetch();
            if ($data !== false) {
                return $data;
            }
        }

        return null;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return Statement|null
     */
    protected function getStatement(string $sql, array $params = []): ?Statement
    {
        try {
            $params = array_values($params);
            $connection = $this->getEntityManager()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (DBALException $e) {
            return null;
        }
    }

    public function findDataResults(string $sql, array $params = []): array
    {
        $statement = $this->getStatement($sql, $params);
        if ($statement) {
            return $statement->fetchAll();
        }
        return [];
    }

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getEntityById(string $id)
    {
        return $this->getEntityBy('id', $id);
    }

    /**
     * @throws \Exception
     */
    protected function throwExceptionWhenDbNameIsNull()
    {
        if (static::TABLE_NAME === null) {
            throw new InvalidObjectTypeException('Invalid repository');
        }
    }

    /**
     * @param string $field
     * @param string $value
     * @return mixed|null
     */
    protected function getEntityBy(string $field, string $value)
    {
        if (empty($value)) {
            return null;
        }

        $queryBuilder = $this->createQueryBuilder('main');
        $queryBuilder->where(
            $queryBuilder->expr()->eq('main.' . $field, ':parameter')
        );
        $queryBuilder->setParameter(':parameter', $value);

        try {
            return $queryBuilder->getQuery()->getOneOrNullResult();
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getEntityByUuid(string $id)
    {
        return $this->getEntityBy('uuid', $id);
    }
}
