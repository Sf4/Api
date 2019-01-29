<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 28.01.19
 * Time: 19:30
 */

namespace Sf4\Api\Dto\Filter;

use Doctrine\ORM\QueryBuilder;

class FilterQueryBuilder
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     */
    public static function buildQuery(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        if(empty($filterItem->getValue())) {
            return ;
        }
        switch ($filterItem->getType()) {
            case FilterItemInterface::TYPE_LIKE:
                $expression = static::addLikeExpression($queryBuilder, $filterItem, $fieldName);
                break;
            case FilterItemInterface::TYPE_EQUAL:
                $expression = static::addEqualExpression($queryBuilder, $filterItem, $fieldName);
                break;
            case FilterItemInterface::TYPE_NOT_EQUAL:
                $expression = static::addNotEqualExpression($queryBuilder, $filterItem, $fieldName);
                break;
            case FilterItemInterface::TYPE_IN:
                $expression = static::addInExpression($queryBuilder, $filterItem, $fieldName);
                break;
            case FilterItemInterface::TYPE_NOT_IN:
                $expression = static::addNotInExpression($queryBuilder, $filterItem, $fieldName);
                break;
            case FilterItemInterface::TYPE_IS_NULL:
                $expression = static::addIsNullExpression($queryBuilder, $fieldName);
                break;
            case FilterItemInterface::TYPE_NOT_NULL:
                $expression = static::addIsNotNullExpression($queryBuilder, $fieldName);
                break;
            default: $expression = null;
        }
        if($expression) {
            $queryBuilder->andWhere(
                $expression
            );
        }
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     * @return \Doctrine\ORM\Query\Expr\Comparison
     */
    protected static function addLikeExpression(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        $paramKey = uniqid(':like_');
        $queryBuilder->setParameter($paramKey, $filterItem->getValue());
        return $queryBuilder->expr()->like($fieldName, $paramKey);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     * @return \Doctrine\ORM\Query\Expr\Comparison
     */
    protected static function addEqualExpression(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        $paramKey = uniqid(':eq_');
        $queryBuilder->setParameter($paramKey, $filterItem->getValue());
        return $queryBuilder->expr()->eq($fieldName, $paramKey);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     * @return \Doctrine\ORM\Query\Expr\Comparison
     */
    protected static function addNotEqualExpression(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        $paramKey = uniqid(':neq_');
        $queryBuilder->setParameter($paramKey, $filterItem->getValue());
        return $queryBuilder->expr()->neq($fieldName, $paramKey);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     * @return \Doctrine\ORM\Query\Expr\Func|null
     */
    protected static function addInExpression(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        $values = static::convertStringToArray($filterItem->getValue());

        if(true === is_array($values)) {
            return $queryBuilder->expr()->in($fieldName, $values);
        }
        return null;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param FilterItemInterface $filterItem
     * @param string $fieldName
     * @return \Doctrine\ORM\Query\Expr\Func|null
     */
    protected static function addNotInExpression(QueryBuilder $queryBuilder, FilterItemInterface $filterItem, string $fieldName)
    {
        $values = static::convertStringToArray($filterItem->getValue());

        if(true === is_array($values)) {
            return $queryBuilder->expr()->notIn($fieldName, $values);
        }
        return null;
    }

    /**
     * @param $string
     * @return array|null
     */
    protected static function convertStringToArray($string)
    {
        if(false === is_array($string) && true === is_scalar($string)) {
            if(false !== strpos($string, ',')) {
                return explode(',', $string);
            } else {
                return [
                    $string
                ];
            }
        }

        return null;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $fieldName
     * @return string
     */
    protected static function addIsNullExpression(QueryBuilder $queryBuilder, string $fieldName)
    {
        return $queryBuilder->expr()->isNull($fieldName);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $fieldName
     * @return string
     */
    protected static function addIsNotNullExpression(QueryBuilder $queryBuilder, string $fieldName)
    {
        return $queryBuilder->expr()->isNotNull($fieldName);
    }
}
