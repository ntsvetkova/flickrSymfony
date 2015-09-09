<?php
/**
 * Created by PhpStorm.
 * User: vkalachikhin
 * Date: 09.09.15
 * Time: 9:54
 */

namespace AppBundle\Models\Registration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\DataCollectorTranslator;

class SignInFormType extends AbstractType
{
    /**
     * @var Translator|DataCollectorTranslator
     */
    protected $translator;

    /**
     * @param DataCollectorTranslator $translator
     */
    public function __construct(DataCollectorTranslator $translator) {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $emptyField = $this->translator->trans('no.input');
        $builderInterface
            ->add('name', 'text', [
                'label' => 'name',
//                'label_attr' => ['class' => 'form_label'],
                'attr' => ['oninvalid' => "setCustomValidity('$emptyField')"]
            ])
            ->add('password', 'password', [
                'label' => 'password',
                'attr' => ['oninvalid' => "setCustomValidity('$emptyField')"]
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'app_sign_in';
    }
}