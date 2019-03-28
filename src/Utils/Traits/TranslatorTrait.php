<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 4.02.19
 * Time: 11:07
 */

namespace Sf4\Api\Utils\Traits;

use Symfony\Contracts\Translation\TranslatorInterface;

trait TranslatorTrait
{

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function translate($id, array $parameters = array(), $domain = null, $locale = null): string
    {
        if ($this->translator) {
            return $this->translator->trans($id, $parameters, $domain, $locale);
        }

        return $id;
    }
}
