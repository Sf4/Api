<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:10
 */

namespace Sf4\Api\Dto\Response;

use Sf4\Api\Dto\DtoInterface;
use Sf4\Api\Notification\NotificationInterface;

interface ResponseSaveDtoInterface extends DtoInterface
{
    public function setOkStatus();

    public function setErrorStatus();

    public function getStatus();

    public function setStatus($status): void;

    public function getMessage();

    public function setMessage($message): void;

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface;

    /**
     * @param NotificationInterface $notification
     */
    public function setNotification(NotificationInterface $notification): void;
}
