<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * The form for the widget listing slider.
 */
class WidgetSliderItemType extends WidgetType
{
    private $mode;
    private $namespace;
    private $businessEntityId;
    private $widget;

    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->mode = $options['mode'];
        $this->namespace = $options['namespace'];
        $this->businessEntityId = $options['businessEntityId'];
        $this->widget = $options['widget'];

        $builder
            ->add('position', 'hidden', [
                'attr' => [
                    'class' => 'vic-position',
                ],
            ]);

        if ($this->mode === Widget::MODE_STATIC) {
            self::addAdvancedMode($builder);
        }

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $advanced = $event->getForm()->has('advanced') && $event->getData() && $event->getData()->isAdvanced();
                $enabled = ($event->getData() && $event->getData()->getEnabled()) || !$event->getData();

                self::addEnabledField($event->getForm(), $enabled);
                self::manageAdvancedMode($event->getForm(), $advanced);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $advanced = (array_key_exists('advanced', $event->getData()) && $event->getData()['advanced']);

                self::manageAdvancedMode($event->getForm(), $advanced);
            });
    }

    /**
     * @param FormInterface $builder
     * @param $value
     */
    private function addEnabledField(FormInterface $builder, $value)
    {
        $builder
            ->add('enabled', 'checkbox', [
                'label'       => 'form.slideritem.enabled.label',
                'data'        => $value,
                'widget_type' => 'inline',
            ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addAdvancedMode(FormBuilderInterface $builder)
    {
        $builder
            ->add('advanced', 'checkbox', [
                'label' => 'widget_slider.form.advanced.label',
                'attr'  => [
                    'data-refreshOnChange' => 'true',
                    'target'               => '.vic-tab-pane.vic-active',
                ],
            ]);
    }

    /**
     * @param FormInterface $form
     * @param $hasAdvancedField
     */
    private function manageAdvancedMode(FormInterface $form, $hasAdvancedField)
    {
        if (!$hasAdvancedField) {
            $form
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
                ]);
        }
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
