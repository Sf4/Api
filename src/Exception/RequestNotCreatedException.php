<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 14.02.19
 * Time: 7:48
 */

namespace Sf4\Api\Exception;

use Throwable;

class RequestNotCreatedException extends \Exception
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Invalid request file';
        }
        parent::__construct($message, $code, $previous);
    }
}
