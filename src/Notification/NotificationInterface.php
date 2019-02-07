<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 9:49
 */

namespace Sf4\Api\Notification;

use Doctrine\Common\Collections\ArrayCollection;

interface NotificationInterface
{
    public function getMessages(): ArrayCollection;

    public function addMessage(MessageInterface $message);

    public function toArray(): array;

    public function hasMessages(): bool;

    public function hasErrorMessages(): bool;
}
