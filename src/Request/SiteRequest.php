<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 19.02.19
 * Time: 7:11
 */

namespace Sf4\Api\Request;

use Sf4\Api\CacheAdapter\CacheKeysInterface;
use Sf4\Api\Request\Traits\GetSiteCacheTags;
use Sf4\Api\Response\SiteResponse;

class SiteRequest extends AbstractRequest
{
    use GetSiteCacheTags;

    public const ROUTE = 'sf4_api_site';

    /**
     * SiteRequest constructor.
     */
    public function __construct()
    {
        $this->init(
            new SiteResponse()
        );
    }

    /**
     * @return array
     */
    protected function getCacheTags(): array
    {
        return [
            CacheKeysInterface::TAG_SITE
        ];
    }
}
