<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 9:07
 */

namespace Sf4\Api\EntitySaver;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Entity\EntityInterface;
use Sf4\Api\Notification\NotificationInterface;
use Sf4\Api\Utils\Traits\EntitymanagerTrait;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractEntitySaver implements EntitySaverInterface
{

    use EntitymanagerTrait;

    abstract protected function populateEntity(EntityInterface $entity, DtoInterface $requestDto);

    abstract protected function validate(
        EntityInterface $entity,
        ValidatorInterface $validator
    ): NotificationInterface;

    /**
     * @param EntityInterface $entity
     * @param DtoInterface $requestDto
     * @return NotificationInterface
     */
    public function save(EntityInterface $entity, DtoInterface $requestDto): NotificationInterface
    {
        $this->populateEntity($entity, $requestDto);

        $validator = Validation::createValidator();
        $notification = $this->validate($entity, $validator);

        if (false === $notification->hasErrorMessages()) {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($entity);
            $entityManager->flush();
        }

        return $notification;
    }
}
