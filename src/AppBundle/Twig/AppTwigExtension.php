<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 28.08.15
 * Time: 13:54
 */

namespace AppBundle\Twig;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppTwigExtension extends \Twig_Extension
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
     * @return array
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('short', array($this, 'shortFunction')),
            new \Twig_SimpleFunction('reverse', array($this, 'reverseFunction')),
            new \Twig_SimpleFunction('show', array($this, 'showFunction'))
        );
    }

    /**
     * @param $array
     * @return array
     */
    public function reverseFunction($array) {
        $reversed = array_reverse($array, true);
        return $reversed;
    }

    /**
     * @param $string
     * @return string
     */
    public function shortFunction($string) {
        $length = mb_strlen($string);
        if ($length > 100) {
            $string = mb_substr($string, 0, 100) . '...';
        }
        return $string;
    }

    /**
     * @param $array
     * @param $count
     * @return mixed
     */
    public function showFunction($array, $count) {
        $showArray = $array;
        if ($count < count($array)) {
            for ($i = count($array) - 1; $i >= $count; $i--) {
                unset($showArray[$i]);
            }
        }
        return $showArray;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'counter_extension';
    }
}