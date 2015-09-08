<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 08.09.15
 * Time: 13:07
 */

namespace AppBundle\LocaleGuesser;


use Lunetics\LocaleBundle\LocaleGuesser\LocaleGuesserInterface;
use Symfony\Component\HttpFoundation\Request;
use Lunetics\LocaleBundle\Validator\MetaValidator;

/**
 * Class AppLocaleGuesser
 * @package AppBundle\LocaleGuesser
 */
class AppLocaleGuesser implements LocaleGuesserInterface
{
    /**
     * @var string
     */
    private $identifiedLocale;
    /**
     * @var MetaValidator
     */
    private $metaValidator;

    /**
     * @param MetaValidator $metaValidator
     */
    public function __construct(MetaValidator $metaValidator)
    {
        $this->metaValidator = $metaValidator;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    public function guessLocale(Request $request)
    {
        if ($foundLocale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $foundLocale);
        }
        else {
            $request->setLocale($request->getSession()->get('_locale', 'en'));
            $foundLocale = $request->getLocale();
        }
        if ($this->metaValidator->isAllowed($foundLocale)) {
            $this->identifiedLocale = $foundLocale;
            return $this->identifiedLocale;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getIdentifiedLocale()
    {
        return $this->identifiedLocale;
    }
}