<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\FormBundle\Form\Type\LinkType;
use Victoire\Bundle\MediaBundle\Form\Type\MediaType;
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
            ->add('position', HiddenType::class, [
                'data' => 0,
                'attr' => [
                    'class' => 'vic-position',
                ],
            ]);

        if ($options['mode'] === Widget::MODE_STATIC) {
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
            ->add('enabled', CheckboxType::class, [
                'label'           => 'form.slideritem.enabled.label',
                'data'            => $value,
                'vic_widget_type' => 'inline'
            ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addAdvancedMode(FormBuilderInterface $builder)
    {
        $builder
            ->add('advanced', CheckboxType::class, [
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
                ->add('link', LinkType::class, [
                    'label'          => 'form.slideritem.linkUrl.label',
                    'vic_help_block' => 'form.slideritem.deprecated',
                ])
                ->add('linkLabel', null, [
                    'label'          => 'form.slideritem.linkLabel.label',
                    'vic_help_block' => 'form.slideritem.deprecated',
                ])
                ->add('image', MediaType::class, [
                    'label' => 'form.slideritem.image.label',
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSliderItem',
            'translation_domain' => 'victoire',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'victoire_widget_form_slideritem';
    }
}
