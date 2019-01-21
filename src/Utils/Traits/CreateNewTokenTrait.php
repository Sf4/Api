<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 21.01.19
 * Time: 8:41
 */

namespace Sf4\Api\Utils\Traits;

use Ramsey\Uuid\Uuid;

trait CreateNewTokenTrait
{

    public function createNewToken(): string
    {
        try {
            $token = Uuid::uuid4();
        } catch (\Exception $exception) {
            $token = md5(
                sha1(
                    microtime()
                )
            );
        }

        return $token;
    }
}
