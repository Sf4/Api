<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:30
 */

namespace Sf4\Api\RequestHandler\Traits;

interface SitesTraitInterface
{
    /**
     * @return array|null
     */
    public function getSites(): ?array;

    /**
     * @param array|null $sites
     */
    public function setSites(?array $sites): void;

    /**
     * @param array|null $sites
     */
    public function addSites(?array $sites);

    /**
     * @param array $site
     */
    public function addSite(array $site);
}
