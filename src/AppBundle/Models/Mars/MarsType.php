<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 31.08.15
 * Time: 14:02
 */

namespace AppBundle\Models\Mars;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class MarsType
 * @package AppBundle\Models\Mars
 */
class MarsType extends AbstractType
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @param $attributes
     */
    public function __construct($attributes) {
        $this->attributes = $attributes;
    }

    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $builderInterface
            ->add('enterData', 'textarea', array(
                'label' => 'enter.data',
                'attr' => array('rows' => $this->attributes['rows'])
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_mars';
    }
}