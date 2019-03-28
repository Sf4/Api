<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 8:02
 */

namespace Sf4\Api\Notification;

use Doctrine\Common\Collections\ArrayCollection;
use Sf4\Api\Utils\Traits\ArrayCollectionToArrayTrait;

class BaseNotification implements NotificationInterface
{

    use ArrayCollectionToArrayTrait;

    /** @var ArrayCollection $messages */
    protected $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getMessages(): ArrayCollection
    {
        return $this->messages;
    }

    public function addMessage(MessageInterface $message): void
    {
        $this->getMessages()->add($message);
    }

    public function toArray(): array
    {
        return $this->arrayCollectionToArray($this->messages);
    }

    public function hasMessages(): bool
    {
        return $this->getMessages()->count() > 0;
    }

    public function hasErrorMessages(): bool
    {
        if ($this->getMessages()->count() <= 0) {
            return false;
        }

        foreach ($this->messages as $message) {
            if ($message instanceof ErrorMessageInterface) {
                return true;
            }
        }

        return false;
    }
}
