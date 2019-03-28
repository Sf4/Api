<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:08
 */

namespace Sf4\Api\Dto\Response;

use Sf4\Api\Entity\Traits\StatusTrait;
use Sf4\Api\Notification\NotificationInterface;

abstract class AbstractResponseSaveDto implements ResponseSaveDtoInterface
{
    use StatusTrait;

    public const STATUS_OK = 'OK';
    public const STATUS_ERROR = 'ERROR';

    public const FIELD_STATUS = 'status';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_NOTIFICATION = 'notification';

    protected $message;

    /** @var NotificationInterface */
    protected $notification;

    public function setOkStatus(): void
    {
        $this->status = static::STATUS_OK;
    }

    public function setErrorStatus(): void
    {
        $this->status = static::STATUS_ERROR;
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
