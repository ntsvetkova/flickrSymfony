<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 08.09.15
 * Time: 16:14
 */

namespace AppBundle\LocaleGuesser;

/**
 * Class AppLocaleTransform
 * @package AppBundle\LocaleGuesser
 */
class AppLocaleTransform
{
    /**
     * @var string
     */
    private $locales;

    /**
     * @param array $locales
     */
    public function __construct(array $locales) {
        $this->locales = implode('|',$locales);
    }

    /**
     * @return string
     */
    public function getLocales() {
        return $this->locales;
    }
}