<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 9:10
 */

namespace Sf4\Api\Request;

use Sf4\Api\CacheAdapter\CacheKeysInterface;
use Sf4\Api\Response\DefaultResponse;

class DefaultRequest extends AbstractRequest
{
    const ROUTE = 'sf4_api_default';

    public function __construct()
    {
        $this->init(
            new DefaultResponse()
        );
    }

    protected function getCacheTags(): array
    {
        return [
            CacheKeysInterface::TAG_SITE
        ];
    }

    protected function getCacheExpiresAfter(): ?int
    {
        return null;
    }
}
