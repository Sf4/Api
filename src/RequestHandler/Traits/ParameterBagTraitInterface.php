<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 3.04.19
 * Time: 8:42
 */

namespace Sf4\Api\RequestHandler\Traits;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

interface ParameterBagTraitInterface
{
    /**
     * @return ParameterBagInterface
     */
    public function getParameterBag(): ParameterBagInterface;

    /**
     * @param ParameterBagInterface $parameterBag
     */
    public function setParameterBag(ParameterBagInterface $parameterBag): void;

    /**
     * @param string $name
     * @return string|null
     */
    public function getParameter(string $name): ?string;
}
