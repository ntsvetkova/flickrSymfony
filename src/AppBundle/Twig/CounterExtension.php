<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 28.08.15
 * Time: 13:54
 */

namespace AppBundle\Twig;

/**
 * Class CounterExtension
 * @package AppBundle\Twig
 */
class CounterExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('counter', array($this, 'counterFilter')),
        );
    }

    /**
     * @param $string
     * @param $count
     * @return string
     */
    public function counterFilter($string, $count)
    {
        $counter = $count . '. ' . $string;

        return $counter;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'counter_extension';
    }
}