<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * The form for the widget listing slider.
 */
class WidgetSliderItemType extends WidgetType
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
            ->add('title', null, [
                'label'          => 'form.slideritem.title.label',
                'vic_help_block' => 'form.slideritem.deprecated',
            ])
            ->add('subtitle', null, [
                'label'          => 'form.slideritem.subtitle.label',
                'vic_help_block' => 'form.slideritem.deprecated',
            ])
            ->add('link', 'victoire_link', [
                'label'          => 'form.slideritem.linkUrl.label',
                'vic_help_block' => 'form.slideritem.deprecated',
            ])
            ->add('linkLabel', null, [
                'label'          => 'form.slideritem.linkLabel.label',
                'vic_help_block' => 'form.slideritem.deprecated',
            ])
            ->add('image', 'media', [
                'label' => 'form.slideritem.image.label',
            ])
            ->add('enabled', 'checkbox', [
                'label' => 'form.slideritem.enabled.label',
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
        return 'victoire_widget_form_slideritem';
    }
}
