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
class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function getName()
    {
        return 'app_extension';
    }
}