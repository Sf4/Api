<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:01
 */

namespace Sf4\Api\Request\Traits;

use Sf4\Api\CacheAdapter\CacheKeysInterface;

trait GetSiteCacheTags
{
    protected function getSiteCacheTags(): array
    {
        return [
            CacheKeysInterface::TAG_SITE
        ];
    }
}
