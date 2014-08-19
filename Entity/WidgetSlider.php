<?php
namespace Victoire\Widget\SliderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Widget\ListingBundle\Entity\WidgetListing;

/**
 * WidgetList Slider
 *
 * @ORM\Table("vic_widget_slider")
 * @ORM\Entity
 */
class WidgetSlider extends WidgetListing
{
    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="WidgetSliderItem", mappedBy="slider", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     */
    protected $sliderItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sliderItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set sliderItems
     * @param array $sliderItems
     *
     * @return WidgetListing
     */
    public function setSliderItems($sliderItems)
    {
        foreach ($sliderItems as $sliderItem) {
            $sliderItem->setSlider($this);
        }
        $this->sliderItems = $sliderItems;

        return $this;
    }
    /**
     * Add sliderItems
     * @param WidgetListingItem $sliderItem
     *
     * @return WidgetListing
     */
    public function addSliderItem(\Victoire\Widget\ListingBundle\Entity\WidgetListingItem $sliderItem)
    {
        $sliderItem->setSlider($this);
        $this->sliderItems[] = $sliderItem;

        return $this;
    }

    /**
     * Remove sliderItems
     * @param \Victoire\Widget\ListingBundle\Entity\WidgetListingItem $sliderItems
     */
    public function removeSliderItem(\Victoire\Widget\ListingBundle\Entity\WidgetListingItem $sliderItems)
    {
        $this->sliderItems->removeElement($sliderItems);
    }

    /**
     * Get sliderItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSliderItems()
    {
        return $this->sliderItems;
    }
}
