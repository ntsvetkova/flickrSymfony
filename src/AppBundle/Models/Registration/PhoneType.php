<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 16.09.15
 * Time: 12:02
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PhoneType
 * @package AppBundle\Models\Registration
 */
class PhoneType extends AbstractType {

    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options)
    {
        $builderInterface
            ->add('number', 'text', [
                'label' => 'user.phone',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Phone',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_phone';
    }
}