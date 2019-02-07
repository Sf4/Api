<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:52
 */

namespace Sf4\Api\EntitySaver;

use Doctrine\ORM\EntityManagerInterface;
use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Entity\EntityInterface;
use Sf4\Api\Notification\NotificationInterface;
use Sf4\Api\Response\ResponseTraitInterface;

interface EntitySaverInterface extends ResponseTraitInterface
{

    /**
     * @param EntityInterface $entity
     * @param DtoInterface $requestDto
     * @return NotificationInterface
     */
    public function save(EntityInterface $entity, DtoInterface $requestDto): NotificationInterface;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void;

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;
}
