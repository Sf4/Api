<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 4.02.19
 * Time: 11:08
 */

namespace Sf4\Api\Utils\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerTrait
{

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
