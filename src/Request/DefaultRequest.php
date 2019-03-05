<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.01.19
 * Time: 9:10
 */

namespace Sf4\Api\Request;

use Sf4\Api\Request\Traits\GetSiteCacheTags;
use Sf4\Api\Response\DefaultResponse;

class DefaultRequest extends AbstractRequest
{
    use GetSiteCacheTags;

    const ROUTE = 'sf4_api_default';

    /**
     * DefaultRequest constructor.
     */
    public function __construct()
    {
        $this->init(
            new DefaultResponse()
        );
    }

    /**
     * @return array
     */
    protected function getCacheTags(): array
    {
        return $this->getCacheTags();
    }

    /**
     * @return string|null
     */
    protected function getCacheKey(): ?string
    {
        return $this->getRoute();
    }
}
