<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:02
 */

namespace Sf4\Api\Response;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Dto\Response\ResponseSaveDtoInterface;
use Sf4\Api\Entity\EntityInterface;
use Sf4\Api\EntitySaver\EntitySaverInterface;
use Sf4\Api\Notification\NotificationInterface;
use Sf4\Api\Repository\RepositoryInterface;

abstract class AbstractSaveResponse extends AbstractResponse
{
    const MESSAGE_SUCCESS = 'save.success';
    const MESSAGE_ERROR = 'save.error';

    abstract protected function getSaveDtoClass(): string;

    public function init()
    {
        $requestDto = $this->getRequest()->getDto();
        $saveDtoClass = $this->getSaveDtoClass();
        /** @var ResponseSaveDtoInterface $saveDto */
        $saveDto = new $saveDtoClass();

        /** @var NotificationInterface $notifications */
        $notifications = $this->save($requestDto);
        if ($notifications->hasErrorMessages()) {
            $saveDto->setOkStatus();
            $message = $this->getMessage(true);
        } else {
            $saveDto->setErrorStatus();
            $message = $this->getMessage(false);
        }

        $saveDto->setMessage($message);
        $this->setResponseDto($saveDto);
    }

    abstract protected function getEntityClass(): string;

    abstract protected function getEntitySaverClass(): string;

    protected function save(DtoInterface $requestDto): NotificationInterface
    {
        $entityManager = $this->getRequest()->getRequestHandler()->getEntityManager();
        $entityClass = $this->getEntityClass();
        $entity = null;
        $uuid = $this->getRequest()->getRequest()->attributes->get('id');
        if ($uuid) {
            /** @var RepositoryInterface $repository */
            $repository = $entityManager->getRepository($entityClass);
            /** @var EntityInterface $entity */
            $entity = $repository->getEntityByUuid($uuid);
        }
        if (!$entity) {
            $entity = new $entityClass();
        }

        $entitySaverClass = $this->getEntitySaverClass();
        /** @var EntitySaverInterface $entitySaver */
        $entitySaver = new $entitySaverClass();
        $entitySaver->setEntityManager($entityManager);

        return $entitySaver->save($entity, $requestDto);
    }

    abstract protected function getMessageCodePrefix(): string;

    protected function getMessage(bool $isSuccess)
    {
        if ($isSuccess === true) {
            $code = static::MESSAGE_SUCCESS;
        } else {
            $code = static::MESSAGE_ERROR;
        }

        $prefix = $this->getMessageCodePrefix();
        $translator = $this->getRequest()->getRequestHandler()->getTranslator();
        $translation = $translator->trans($prefix . $code);

        if ($translation === $prefix . $code) {
            $translation = $translator->trans($code);
        }

        return $translation;
    }
}
