<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:21
 */

namespace Sf4\Api\Repository;

interface RepositoryInterface
{
    /**
     * @param $id
     * @return array|null
     * @throws \Exception
     */
    public function findDataById($id): ?array;

    /**
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function findOneOrNullData(string $sql, array $params = []): ?array;

    public function findDataResults(string $sql, array $params = []): array;

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getEntityById(string $id);

    /**
     * @param string $id
     * @return mixed|null
     */
    public function getEntityByUuid(string $id);
}
