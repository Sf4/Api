<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 3.04.19
 * Time: 8:40
 */

namespace Sf4\Api\RequestHandler\Traits;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

trait ParameterBagTrait
{
    /** @var ParameterBagInterface $parameterBag */
    protected $parameterBag;

    /**
     * @return ParameterBagInterface
     */
    public function getParameterBag(): ParameterBagInterface
    {
        return $this->parameterBag;
    }

    /**
     * @param ParameterBagInterface $parameterBag
     */
    public function setParameterBag(ParameterBagInterface $parameterBag): void
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getParameter(string $name): ?string
    {
        if ($this->getParameterBag()->has($name)) {
            return $this->getParameterBag()->get($name);
        }

        return null;
    }
}
