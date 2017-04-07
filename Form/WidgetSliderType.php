<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Victoire\Bundle\CoreBundle\Form\WidgetFieldsFormType;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetSliderType form type.
 */
class WidgetSliderType extends WidgetType
{
    const DEFAULT_LIBRARY = 'bootstrap';

    /**
     * define form fields.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('autoplay', null, [
                'label' => 'widget_slider.form.autoplay.label',
                'attr'  => [
                    'data-refreshOnChange' => 'true',
                    'data-target'               => '#picker-'.$options['mode'].'-'.$options['quantum'].' .v-widget-form',
                ],
            ])
            ->add('adaptiveHeight', null, [
                'label' => 'widget_slider.form.adaptiveHeight.label',
            ]);

        self::addSliderItems($builder, $options);
        if ($options['mode'] != Widget::MODE_STATIC) {
            self::addQueryAndBusinessEntityFields($builder, $options);
        }

        parent::buildForm($builder, $options);

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                $library = $event->getData()->getLibrary() !== null ? $event->getData()->getLibrary() : self::DEFAULT_LIBRARY;

                self::manageLibrary($event->getForm(), $library, $options['quantum'], $options['mode']);
                self::manageAutoplaySpeed($event->getForm(), $event->getData()->getAutoplay());
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($options) {
                $library = $event->getData()['library'] !== null ? $event->getData()['library'] : self::DEFAULT_LIBRARY;
                $autoplay = (array_key_exists('autoplay', $event->getData()) && $event->getData()['autoplay']);

                self::manageLibrary($event->getForm(), $library, $options['quantum'], $options['mode']);
                self::manageAutoplaySpeed($event->getForm(), $autoplay);
            });
    }

    /**
     * if no entity is given, we generate the static form
     * else, WidgetType class will embed a EntityProxyType for given entity.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    private function addSliderItems(FormBuilderInterface $builder, $options)
    {
        $builder
            ->add('sliderItems', CollectionType::class, [
                'entry_type'    => WidgetSliderItemType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'id' => ($options['mode'] === Widget::MODE_STATIC) ? 'static' : $options['businessEntityId'],
                ],
                'options'       => [
                    'mode'             => $options['mode'],
                ],
            ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addQueryAndBusinessEntityFields(FormBuilderInterface $builder, $options)
    {
        $builder
            ->add('slot', HiddenType::class)
            ->add('fields', WidgetFieldsFormType::class, [
                'businessEntityId' => $options['businessEntityId'],
                'widget'    => $options['widget'],
            ]);
    }

    /**
     * @param FormInterface $form
     * @param $autoplay
     */
    private function manageAutoplaySpeed(FormInterface $form, $autoplay = false)
    {
        if ($autoplay) {
            $form
                ->add('autoplaySpeed', null, [
                    'label' => 'widget_slider.form.autoplaySpeed.label',
                ]);
        } else {
            $form->remove('autoplaySpeed');
        }
    }

    /**
     * @param FormInterface $form
     * @param $library
     */
    private function manageLibrary(FormInterface $form, $library, $quantum, $mode)
    {
        $form
            ->add('library', ChoiceType::class, [
                'label'          => 'widget_slider.form.library.label',
                'choices'        => [
                    'Bootstrap' => 'bootstrap',
                    'Slick'     => 'slick',
                ],
                'choices_as_values' => true,
                'required'          => true,
                'vic_help_block'    => sprintf('widget_slider.form.library.%s.help', strtolower($library)),
                'attr'              => [
                    'data-refreshOnChange' => 'true',
                    'data-target'               => '#picker-'.$mode.'-'.$quantum.' .v-widget-form',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSlider',
            'widget'             => 'widgetslideritem',
            'translation_domain' => 'victoire',
        ]);
    }
}
