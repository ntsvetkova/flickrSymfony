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
/**
 * Class UserType
 * @package AppBundle\Models\Registration
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     * TODO password validation
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $builderInterface
            ->add('_username', 'text', [
                'label' => 'user.name',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('country', 'text', [
                'label' => 'user.country',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', 'email', [
                'label' => 'user.email',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('age', 'number', [
                'label' => 'user.age',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('phones', 'collection', [
                'label' => false,
                'type' => new PhoneType(),
                'allow_add' => true,
                'by_reference' => false
            ])
            ->add('_password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'value.confirm.error',
                'first_options'  => [
                    'label' => 'user.password',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'user.confirm',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            ]);
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'cascade_validation' => true
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