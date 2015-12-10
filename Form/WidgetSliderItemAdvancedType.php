<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;

/**
 * The form for the widget listing slider.
 */
class WidgetSliderItemAdvancedType extends WidgetType
{
    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', 'checkbox', [
                'label' => 'form.slideritem.enabled.label',
                'data'  => true,
            ])
            ->add('position', 'hidden', [
                'attr' => [
                    'class' => 'vic-position',
                ],
            ]);
    }

    /**
     * bind form to WidgetSliderItem entity.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSliderItem',
            'widget'             => null,
            'translation_domain' => 'victoire',
        ]);
    }

    /**
     * get form name.
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_slideritem_advanced';
    }
}
