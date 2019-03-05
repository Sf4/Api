<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:39
 */

namespace Sf4\Api\Utils\Traits;

use Doctrine\ORM\EntityManagerInterface;

interface EntityManagerTraitInterface
{
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void;
}
