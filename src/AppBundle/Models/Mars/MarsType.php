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

class MarsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $builderInterface
            ->add('enterData', 'textarea', array(
                'attr' => array('rows' => 10)
            ))
//            ->add('showFinalPosition','submit')
        ;
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