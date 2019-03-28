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
    public const MESSAGE_SUCCESS = 'save.success';
    public const MESSAGE_ERROR = 'save.error';

    abstract protected function getSaveDtoClass(): string;

    public function init()
    {
        $request = $this->getRequest();
        $saveDtoClass = $this->getSaveDtoClass();
        /** @var ResponseSaveDtoInterface $saveDto */
        $saveDto = new $saveDtoClass();
        $notifications = null;

        if ($request) {
            $requestDto = $request->getDto();
            if ($requestDto) {
                /** @var NotificationInterface $notifications */
                $notifications = $this->save($requestDto);
            }
        }
        if ($notifications && false === $notifications->hasErrorMessages()) {
            $saveDto->setOkStatus();
            $message = $this->getMessage(true);
        } else {
            $saveDto->setErrorStatus();
            $message = $this->getMessage(false);
        }

        $saveDto->setMessage($message);
        $saveDto->setNotification($notifications);
        $this->setResponseDto($saveDto);
    }

    abstract protected function getEntityClass(): string;

    abstract protected function getEntitySaverClass(): string;

    protected function save(DtoInterface $requestDto): ?NotificationInterface
    {
        $request = $this->getRequest();
        if ($request) {
            $entityClass = $this->getEntityClass();
            $uuid = $request->getRequest()->attributes->get('id');
            $requestHandler = $request->getRequestHandler();

            $entityManager = null;
            if ($requestHandler) {
                $entityManager = $requestHandler->getEntityManager();
            }

            $entity = null;
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
            $entitySaver->setResponse($this);

            return $entitySaver->save($entity, $requestDto);
        }

        return null;
    }

    abstract protected function getMessageCodePrefix(): string;

    protected function getMessage(bool $isSuccess): string
    {
        if ($isSuccess === true) {
            $code = static::MESSAGE_SUCCESS;
        } else {
            $code = static::MESSAGE_ERROR;
        }

        $request = $this->getRequest();
        if ($request) {
            $requestHandler = $request->getRequestHandler();
            if ($requestHandler) {
                $translator = $requestHandler->getTranslator();
                $prefix = $this->getMessageCodePrefix();
                $translation = $translator->trans($prefix . $code);

                if ($translation === $prefix . $code) {
                    $translation = $translator->trans($code);
                }

                return $translation;
            }
        }

        return $code;
    }
}
