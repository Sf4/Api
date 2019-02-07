<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 1.02.19
 * Time: 12:27
 */

namespace Sf4\Api\Repository\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Sf4\Api\Dto\Filter\FilterInterface;
use Sf4\Api\Dto\Order\OrderInterface;
use Sf4\Api\Repository\AbstractRepository;

trait ListTrait
{

    abstract protected function createListQueryBuilder(): QueryBuilder;

    abstract protected function addFilterQuery(QueryBuilder $queryBuilder, FilterInterface $filter = null);

    abstract protected function addOrderQuery(QueryBuilder $queryBuilder, OrderInterface $order);

    public function getListData(FilterInterface $filter = null, ArrayCollection $orders = null): ?array
    {
        $qb = $this->createListQueryBuilderWithFilterAndOrderQueries($filter, $orders);
        return $qb->getQuery()->getArrayResult();
    }

    public function getListDataCount(FilterInterface $filter = null, ArrayCollection $orders = null)
    {
        $qb = $this->createListQueryBuilderWithFilterAndOrderQueries($filter, $orders);
        $qb->select(
            $qb->expr()->count(AbstractRepository::FIELD_ID)
        );

        try {
            $response = $qb->getQuery()->getSingleResult(Query::HYDRATE_SINGLE_SCALAR);
        } catch (NoResultException $e) {
            $response = 0;
        } catch (NonUniqueResultException $e) {
            $response = 0;
        }
        return $response;
    }

    protected function createListQueryBuilderWithFilterAndOrderQueries(
        FilterInterface $filter = null,
        ArrayCollection $orders = null
    ) {
        $queryBuilder = $this->createListQueryBuilder();
        $this->addFilterQuery($queryBuilder, $filter);
        $this->addOrdersQuery($queryBuilder, $orders);

        return $queryBuilder;
    }

    protected function addOrdersQuery(QueryBuilder $queryBuilder, ArrayCollection $orders = null)
    {
        if (!$orders) {
            return;
        }
        /** @var OrderInterface $order */
        foreach ($orders as $order) {
            $this->addOrderQuery($queryBuilder, $order);
        }
    }
}
