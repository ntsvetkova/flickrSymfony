<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 09.09.15
 * Time: 17:54
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $builderInterface
            ->add('username', 'text', [
                'label' => 'user.name',
            ])
            ->add('country', 'text', [
                'label' => 'user.country'
            ])
            ->add('email', 'email', [
                'label' => 'user.email',
            ])
            ->add('password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'value.confirm.error',
                'first_options'  => ['label' => 'user.password'],
                'second_options' => ['label' => 'user.confirm']
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_user';
    }
}