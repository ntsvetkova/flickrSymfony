<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 27.08.15
<<<<<<< HEAD
 * Time: 15:47
=======
 * Time: 16:51
>>>>>>> 12e9b5cdc6195e95852a4c4b38e75644ef9e158e
 */

namespace AppBundle\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LocaleListener
 * @package AppBundle\EventListener
 */
class LocaleListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @param string $defaultLocale
     */
    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        }
        else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
        );
    }
}