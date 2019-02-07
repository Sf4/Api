<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:08
 */

namespace Sf4\Api\Dto\Response;

use Sf4\Api\Notification\NotificationInterface;

abstract class AbstractResponseSaveDto implements ResponseSaveDtoInterface
{
    const STATUS_OK = 'OK';
    const STATUS_ERROR = 'ERROR';

    const FIELD_STATUS = 'status';
    const FIELD_MESSAGE = 'message';
    const FIELD_NOTIFICATION = 'notification';

    protected $status;

    protected $message;

    /** @var NotificationInterface */
    protected $notification;

    public function setOkStatus()
    {
        $this->status = static::STATUS_OK;
    }

    public function setErrorStatus()
    {
        $this->status = static::STATUS_ERROR;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

    /**
     * @param NotificationInterface $notification
     */
    public function setNotification(NotificationInterface $notification): void
    {
        $this->notification = $notification;
    }
}
