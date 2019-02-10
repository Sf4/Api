<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 7:25
 */

namespace Sf4\Api\Notification;

class BaseErrorMessage extends AbstractMessage implements ErrorMessageInterface
{
    const TYPE = 'ERROR';
}
