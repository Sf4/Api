<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 9:56
 */

namespace Sf4\Api\Notification;

interface MessageInterface
{
    const TYPE = 'MESSAGE';

    public function getType(): string;

    public function getMessage(): string;

    public function getKey(): string;

    public function setType(string $type): void;

    public function setMessage(string $message): void;

    public function setKey(string $key): void;
}
