<?php

namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetSliderType form type
 */
class WidgetSliderType extends WidgetType
{

    private $mode;
    private $namespace;
    private $businessEntityId;
    private $widget;

    /**
     * define form fields
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
            ->add('autoplay', null, array(
                'label' => 'widget_slider.form.autoplay.label',
                'attr' => array(
                    'data-refreshOnChange' => "true",
                    'target' => '.vic-tab-pane.vic-active'
                )
            ));

        if ($this->mode === Widget::MODE_STATIC) {
            self::addSliderItems($builder, true);
        } else {
            self::addSliderItems($builder, false);
            self::addQueryAndBusinessEntityFields($builder);
        }

        parent::buildForm($builder, $options);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) {
                $library = $event->getData()->getLibrary() !== null ? $event->getData()->getLibrary() : 'bootstrap';
                self::manageLibrary($event->getForm(), $library);
                self::manageAutoplaySpeed($event->getForm(), $event->getData()->getAutoplay());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event) {
                $library = $event->getData()['library'] !== null ? $event->getData()['library'] : 'bootstrap';
                self::manageLibrary($event->getForm(), $library);
                $autoplay = (array_key_exists('autoplay', $event->getData()) && $event->getData()['autoplay']);
                self::manageAutoplaySpeed($event->getForm(), $autoplay);
            }
        );
    }

    /**
     * if no entity is given, we generate the static form
     * else, WidgetType class will embed a EntityProxyType for given entity
     *
     * @param $builder
     * @param bool $static
     */
    private function addSliderItems($builder, $static = false)
    {
        $builder->add('sliderItems', 'collection', array(
            'type'         => new WidgetSliderItemType($this->businessEntityId, $this->namespace, $this->widget),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            "attr"         => array('id' => $static ? 'static' : $this->businessEntityId),
            'options'      => array(
                'namespace'        => $this->namespace,
                'businessEntityId' => $this->businessEntityId,
                'mode'             => $this->mode
            ),
        ));
    }

    /**
     * @param $builder
     */
    private function addQueryAndBusinessEntityFields($builder)
    {
        $builder
            ->add('slot', 'hidden')
            ->add('fields', 'widget_fields', array(
                "namespace" => $this->namespace,
                "widget"    => $this->widget
            ));
    }

    /**
     * @param FormInterface $form
     * @param $autoplay
     */
    private function manageAutoplaySpeed(FormInterface $form, $autoplay = false)
    {
        if($autoplay) {
            $form->add('autoplaySpeed', null, array(
                'label' => 'widget_slider.form.autoplaySpeed.label'
            ));
        } else {
            $form->remove('autoplaySpeed');
        }
    }

    private function manageLibrary(FormInterface $form, $library)
    {
        $form->add('library', 'choice', array(
            'label' => 'widget_slider.form.library.label',
            'vic_help_block' => sprintf(
                'widget_slider.form.library.%s.help',
                $library
            ),
            'attr' => array(
                'data-refreshOnChange' => "true",
                'target' => '.vic-tab-pane.vic-active'
            ),
            'required' => true,
            'choices' => array(
                'bootstrap' => 'Bootstrap',
                'slick' => 'Slick'
            )
        ));
    }

    /**
     * bind form to WidgetRedactor entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSlider',
            'widget'             => 'widgetslideritem',
            'translation_domain' => 'victoire'
        ));
    }

    /**
     * get form name
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_slider';
    }
}
