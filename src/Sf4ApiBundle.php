<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 25.02.19
 * Time: 9:41
 */

namespace Sf4\Api;

use Sf4\Api\DependencyInjection\Sf4ApiExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Sf4ApiBundle extends Bundle
{

    /**
     * @return Sf4ApiExtension|\Symfony\Component\DependencyInjection\Extension\ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        return new Sf4ApiExtension();
    }
}
