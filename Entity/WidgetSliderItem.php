<?php

namespace Victoire\Widget\SliderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\CoreBundle\Annotations as VIC;
use Victoire\Widget\ListingBundle\Entity\WidgetListingItem;
use Victoire\Bundle\MediaBundle\Entity\Media;

/**
 * WidgetSliderItem
 *
 * @ORM\Table("vic_widget_slider_item")
 * @ORM\Entity
 */
class WidgetSliderItem extends WidgetListingItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="link_label", type="string", length=55)
     */
    protected $linkLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="link_url", type="string", length=255)
     */
    protected $linkUrl;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE")
     * @VIC\ReceiverProperty("imageable")
     *
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="WidgetSlider", inversedBy="sliderItems")
     * @ORM\JoinColumn(name="listing_id", referencedColumnName="id", onDelete="CASCADE")
     *
     */
    protected $slider;

    /**
     * Get the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get fields
     *
     * @return string
     */
    public function getFields()
    {
        return $this->getSlider()->getFields();
    }

    /**
     * Set linkLabel
     *
     * @param string $linkLabel
     *
     * @return WidgetSliderItem
     */
    public function setLinklabel($linkLabel)
    {
        $this->linkLabel = $linkLabel;

        return $this;
    }

    /**
     * Get linkLabel
     *
     * @return string
     */
    public function getLinklabel()
    {
        return $this->linkLabel;
    }

    /**
     * Set linkUrl
     *
     * @param string $linkUrl
     *
     * @return WidgetSliderItem
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    /**
     * Get linkUrl
     *
     * @return string
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Set image
     *
     * @param  Media       $image
     * @return WidgetImage
     */
    public function setImage(Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slider
     *
     * @param  WidgetSlider     $slider
     * @return WidgetSliderItem
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return string
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
