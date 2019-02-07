<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 9:55
 */

namespace Sf4\Api\Notification\Traits;

use Sf4\Api\Notification\BaseErrorMessage;
use Sf4\Api\Notification\NotificationInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ConvertViolationsToErrorMessage
{

    /**
     * @param ConstraintViolationListInterface $violationList
     * @param NotificationInterface $notification
     * @param string $fieldName
     */
    protected function convertViolationsToErrormessage(
        ConstraintViolationListInterface $violationList,
        NotificationInterface $notification,
        string $fieldName
    ) {
        if (0 !== count($violationList)) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violationList as $violation) {
                $errorMessage = new BaseErrorMessage();
                $errorMessage->setKey($fieldName);
                $errorMessage->setMessage($violation->getMessage());
                $notification->addMessage($errorMessage);
            }
        }
    }
}
