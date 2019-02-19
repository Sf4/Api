<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.02.19
 * Time: 9:06
 */

namespace Sf4\Api\RequestHandler\Traits;

trait SitesTrait
{
    /** @var array|null $sites */
    protected $sites;

    /**
     * @return array|null
     */
    public function getSites(): ?array
    {
        return $this->sites;
    }

    /**
     * @param array|null $sites
     */
    public function setSites(?array $sites): void
    {
        $this->sites = $sites;
    }
}
