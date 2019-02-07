<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 7:21
 */

namespace Sf4\Api\Notification;

class BaseMessage implements MessageInterface
{
    /** @var string $type */
    protected $type;

    /** @var string $message */
    protected $message;

    /** @var string $key */
    protected $key;

    public function __construct()
    {
        $this->setType(static::TYPE);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'key' => $this->getKey(),
            'message' => $this->getMessage()
        ];
    }
}
