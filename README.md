Victoire DCMS Slider Bundle
============

##What is the purpose of this bundle

This bundles gives you access to the *Slider Widget* which integrates sliders on your website.
You can choose the style of the sliders among Slick and Bootstrap.

##Set Up Victoire

If you haven't already, you can follow the steps to set up Victoire *[here](https://github.com/Victoire/victoire/blob/master/setup.md)*

##Install the bundle

    php composer.phar require friendsofvictoire/slider-widget

This bundle requires to install the [Listing bundle](https://github.com/FriendsOfVictoire/WidgetListingBundle)*

###Reminder

Do not forget to add the bundle in your AppKernel !

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                ...
                new Victoire\Widget\SliderBundle\VictoireWidgetSliderBundle(),
            );

            return $bundles;
        }
    }
