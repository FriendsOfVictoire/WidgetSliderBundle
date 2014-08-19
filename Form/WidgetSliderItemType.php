<?php
namespace Victoire\Widget\SliderBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * The form for the widget listing slider
 *
 */
class WidgetSliderItemType extends WidgetType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'textarea', array(
                'attr' => array(
                    'rows' => 3,
                ),
                'label' => 'form.slideritem.title.label')
            )
            ->add('description', 'textarea', array(
                'attr' => array(
                    'rows' => 3),
                'label' => 'form.slideritem.description.label'))
            ->add('linkUrl', null, array(
                'label' => 'form.slideritem.linkUrl.label'))
            ->add('linkLabel', null, array(
                'label' => 'form.slideritem.linkLabel.label'))
            ->add('image', 'media', array(
                'label' => 'form.slideritem.image.label'));
    }

    /**
     * bind form to WidgetSliderItem entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\SliderBundle\Entity\WidgetSliderItem',
            'widget'             => null,
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
        return 'victoire_widget_form_slideritem';
    }
}
