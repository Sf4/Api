<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 18.02.19
 * Time: 9:06
 */

namespace Sf4\Api\RequestHandler\Traits;

use Sf4\Api\DependencyInjection\Configuration;

trait SitesTrait
{
    /** @var array|null $sites */
    protected $sites = [];

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

    /**
     * @param array|null $sites
     */
    public function addSites(?array $sites)
    {
        if (!$sites) {
            return ;
        }

        foreach ($sites as $site) {
            $this->addSite($site);
        }
    }

    /**
     * @param array $site
     */
    public function addSite(array $site)
    {
        if (isset($site[Configuration::SITES_SITE]) &&
            isset($site[Configuration::SITES_URL]) &&
            isset($site[Configuration::SITES_TOKEN])) {
            foreach ($this->sites as $thisSite) {
                if ($thisSite[Configuration::SITES_SITE] === $site[Configuration::SITES_SITE]) {
                    return ;
                }
            }
            $this->sites[] = $site;
        }
    }
}
