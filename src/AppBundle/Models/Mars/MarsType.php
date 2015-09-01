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
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\DataCollectorTranslator;

/**
 * Class MarsType
 * @package AppBundle\Models\Mars
 */
class MarsType extends AbstractType
{
    /**
     * @var Translator|DataCollectorTranslator
     */
    protected $translator;
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @param DataCollectorTranslator $translator
     */
    public function __construct(DataCollectorTranslator $translator, $attributes) {
        $this->translator = $translator;
        $this->attributes = $attributes;
    }

    /**
     * @param FormBuilderInterface $builderInterface
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builderInterface, array $options) {
        $emptyField = $this->translator->trans('no.input');
        $builderInterface
            ->add('enterData', 'textarea', array(
                'label' => 'enter.data',
                'attr' => array('rows' => $this->attributes['rows'],
                    'oninvalid' => "setCustomValidity('$emptyField')")
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