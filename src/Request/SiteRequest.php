<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 19.02.19
 * Time: 7:11
 */

namespace Sf4\Api\Request;

use Sf4\Api\CacheAdapter\CacheKeysInterface;
use Sf4\Api\Response\SiteResponse;

class SiteRequest extends AbstractRequest
{

    const ROUTE = 'sf4_api_site';

    public function __construct()
    {
        $this->init(
            new SiteResponse()
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
