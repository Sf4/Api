<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 6.02.19
 * Time: 8:08
 */

namespace Sf4\Api\Dto\Response;

abstract class AbstractResponseSaveDto implements ResponseSaveDtoInterface
{
    const STATUS_OK = 'OK';
    const STATUS_ERROR = 'ERROR';

    protected $status;

    protected $message;

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
}
