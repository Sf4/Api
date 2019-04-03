<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 5.03.19
 * Time: 9:38
 */

namespace Sf4\Api\Utils\Traits;

use Symfony\Contracts\Translation\TranslatorInterface;

interface TranslatorTraitInterface
{
    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface;

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void;

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @param null $locale
     * @return string
     */
    public function translate($id, array $parameters = array(), $domain = null, $locale = null): string;
}
