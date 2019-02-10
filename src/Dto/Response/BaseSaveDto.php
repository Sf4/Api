<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:12
 */

namespace Sf4\Api\Dto\Response;

use Sf4\Api\Notification\BaseNotification;

class BaseSaveDto extends AbstractResponseSaveDto
{

    public function __construct()
    {
        $this->setNotification(new BaseNotification());
    }

    /**
     * @param array|object|null $data
     */
    public function populate(array $data): void
    {
        if (isset($data[static::FIELD_STATUS])) {
            $this->setStatus($data[static::FIELD_STATUS]);
        }
        if (isset($data[static::FIELD_MESSAGE])) {
            $this->setMessage($data[static::FIELD_MESSAGE]);
        }
        if (isset($data[static::FIELD_NOTIFICATION])) {
            $this->setNotification($data[static::FIELD_NOTIFICATION]);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            static::FIELD_STATUS => $this->getStatus(),
            static::FIELD_MESSAGE => $this->getMessage(),
            static::FIELD_NOTIFICATION => $this->getNotification()->toArray()
        ];
    }
}
