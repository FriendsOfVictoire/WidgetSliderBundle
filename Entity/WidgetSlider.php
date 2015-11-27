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
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $sliderItems;

    /**
     * @ORM\Column(name="library", type="string", length=255, nullable=true)
     */
    protected $library;

    /**
     * @ORM\Column(name="bullets", type="boolean")
     * @deprecated
     */
    protected $bullets;

    /**
     * @ORM\Column(name="autoplay", type="boolean")
     */
    protected $autoplay;

    /**
     * @ORM\Column(name="autoplaySpeed", type="string", length=255)
     */
    protected $autoplaySpeed = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sliderItems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bullets = true;
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

    /**
     * @return mixed
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * @param mixed $library
     *
     * @return $this
     */
    public function setLibrary($library)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutoplay()
    {
        return $this->autoplay;
    }

    /**
     * @param mixed $autoplay
     *
     * @return $this
     */
    public function setAutoplay($autoplay)
    {
        $this->autoplay = $autoplay;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAutoplaySpeed()
    {
        return $this->autoplaySpeed;
    }

    /**
     * @param mixed $autoplaySpeed
     *
     * @return $this
     */
    public function setAutoplaySpeed($autoplaySpeed)
    {
        $this->autoplaySpeed = $autoplaySpeed;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBullets()
    {
        return $this->bullets;
    }

    /**
     * @param mixed $bullets
     *
     * @return $this
     */
    public function setBullets($bullets)
    {
        $this->bullets = $bullets;

        return $this;
    }

}
