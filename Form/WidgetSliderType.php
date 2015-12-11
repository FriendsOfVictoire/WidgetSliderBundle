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
 * WidgetSliderType form type.
 */
class WidgetSliderType extends WidgetType
{
    const DEFAULT_LIBRARY = 'bootstrap';

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
            ->add('autoplay', null, [
                'label' => 'widget_slider.form.autoplay.label',
                'attr'  => [
                    'data-refreshOnChange' => 'true',
                    'target'               => '.vic-tab-pane.vic-active',
                ],
            ])
            ->add('adaptiveHeight', null, [
                'label' => 'widget_slider.form.adaptiveHeight.label',
            ]);


        self::addSliderItems($builder);
        if ($this->mode != Widget::MODE_STATIC) {
            self::addQueryAndBusinessEntityFields($builder);
        }

        parent::buildForm($builder, $options);

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $library = $event->getData()->getLibrary() !== null ? $event->getData()->getLibrary() : self::DEFAULT_LIBRARY;

                self::manageLibrary($event->getForm(), $library);
                self::manageAutoplaySpeed($event->getForm(), $event->getData()->getAutoplay());
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $library = $event->getData()['library'] !== null ? $event->getData()['library'] : self::DEFAULT_LIBRARY;
                $autoplay = (array_key_exists('autoplay', $event->getData()) && $event->getData()['autoplay']);

                self::manageLibrary($event->getForm(), $library);
                self::manageAutoplaySpeed($event->getForm(), $autoplay);
            });
    }

    /**
     * if no entity is given, we generate the static form
     * else, WidgetType class will embed a EntityProxyType for given entity.
     */
    private function addSliderItems(FormBuilderInterface $builder)
    {
        $sliderItems = new WidgetSliderItemType($this->businessEntityId, $this->namespace, $this->widget);

        $builder
            ->add('sliderItems', 'collection', [
                'type'         => $sliderItems,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr'         => [
                    'id' => ($this->mode === Widget::MODE_STATIC) ? 'static' : $this->businessEntityId,
                ],
                'options'      => [
                    'namespace'        => $this->namespace,
                    'businessEntityId' => $this->businessEntityId,
                    'mode'             => $this->mode,
                ],
            ]);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addQueryAndBusinessEntityFields(FormBuilderInterface $builder)
    {
        $builder
            ->add('slot', 'hidden')
            ->add('fields', 'widget_fields', [
                'namespace' => $this->namespace,
                'widget'    => $this->widget,
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
    private function manageLibrary(FormInterface $form, $library)
    {
        $form
            ->add('library', 'choice', [
                'label'          => 'widget_slider.form.library.label',
                'vic_help_block' => sprintf('widget_slider.form.library.%s.help', $library),
                'attr'           => [
                    'data-refreshOnChange' => 'true',
                    'target'               => '.vic-tab-pane.vic-active',
                ],
                'required'      => true,
                'choices'       => [
                    'bootstrap' => 'Bootstrap',
                    'slick'     => 'Slick',
                ],
            ]);
    }

    /**
     * bind form to WidgetRedactor entity.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSlider',
            'widget'             => 'widgetslideritem',
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
        return 'victoire_widget_form_slider';
    }
}
