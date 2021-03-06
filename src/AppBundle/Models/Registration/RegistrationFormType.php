<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 08.09.15
 * Time: 18:00
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $builderInterface
            ->add('user', new UserType(), ['label' => false]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_registration';
    }
}