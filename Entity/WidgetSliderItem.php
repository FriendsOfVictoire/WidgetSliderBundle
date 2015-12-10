<?php

namespace Victoire\Widget\SliderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\CoreBundle\Annotations as VIC;
use Victoire\Bundle\MediaBundle\Entity\Media;
use Victoire\Bundle\WidgetBundle\Entity\Traits\LinkTrait;
use Victoire\Widget\ImageBundle\Entity\WidgetImage;
use Victoire\Widget\ListingBundle\Entity\WidgetListingItem;

/**
 * WidgetSliderItem.
 *
 * @ORM\Table("vic_widget_slider_item")
 * @ORM\Entity
 */
class WidgetSliderItem extends WidgetListingItem
{
    use LinkTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled = true;

    /**
     * @var string
     *
     * @ORM\Column(name="advanced", type="boolean")
     */
    protected $advanced = false;

    /**
     * @var string
     *
     * @ORM\Column(name="link_label", type="string", length=55, nullable=true)
     */
    protected $linkLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     * @VIC\ReceiverProperty("textable")
     */
    protected $subtitle;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE")
     * @VIC\ReceiverProperty("imageable")
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="WidgetSlider", inversedBy="sliderItems")
     * @ORM\JoinColumn(name="listing_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $slider;

    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set linkLabel.
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
     * Get linkLabel.
     *
     * @return string
     */
    public function getLinklabel()
    {
        return $this->linkLabel;
    }

    /**
     * Set image.
     *
     * @param Media $image
     *
     * @return WidgetImage
     */
    public function setImage(Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set slider.
     *
     * @param WidgetSlider $slider
     *
     * @return WidgetSliderItem
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider.
     *
     * @return string
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     *
     * @return $this
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function isAdvanced()
    {
        return $this->advanced;
    }

    /**
     * @param string $advanced
     */
    public function setAdvanced($advanced)
    {
        $this->advanced = $advanced;
    }
}
