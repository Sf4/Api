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
use Sf4\Api\RequestHandler\RequestHandlerInterface;
use Sf4\Api\Response\ResponseTrait;
use Sf4\Api\Utils\Traits\EntityManagerTrait;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractEntitySaver implements EntitySaverInterface
{

    use EntityManagerTrait;
    use ResponseTrait;

    /**
     * @param EntityInterface $entity
     * @param DtoInterface $requestDto
     * @return mixed
     */
    abstract protected function populateEntity(EntityInterface $entity, DtoInterface $requestDto);

    /**
     * @param EntityInterface $entity
     * @param ValidatorInterface $validator
     * @return NotificationInterface
     */
    abstract protected function validate(
        EntityInterface $entity,
        ValidatorInterface $validator
    ): NotificationInterface;

    /**
     * @param EntityInterface $entity
     * @return mixed
     */
    abstract protected function postEntitySave(EntityInterface $entity);

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
            $this->postEntitySave($entity);
        }
        return $notification;
    }

    /**
     * @return RequestHandlerInterface|null
     */
    public function getRequestHandler(): ?RequestHandlerInterface
    {
        $response = $this->getResponse();
        if ($response) {
            return $response->getRequestHandler();
        }

        return null;
    }
}
