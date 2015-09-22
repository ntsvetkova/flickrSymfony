<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 22.09.15
 * Time: 15:26
 */

namespace AppBundle\Models\Feedback;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FeedbackType
 * @package AppBundle\Models\Feedback
 */
class FeedbackType extends AbstractType {

    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options)
    {
        $builderInterface
            ->add('username', 'text', [
                'label' => 'user.name',
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
            ->add('message', 'textarea',[
                'label' => 'message',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '10'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Feedback',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_feedback';
    }
}