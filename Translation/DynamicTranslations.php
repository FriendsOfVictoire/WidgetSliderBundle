<?php

namespace Victoire\Widget\SliderBundle\Translation;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

/**
 * @author Paul Andrieux
 */
class DynamicTranslations implements TranslationContainerInterface
{
    /**
     * usage example: new Message('example.keymap')->addSource('path/to/source/file', '514', '10'),.
     *
     * @return array the keys to register in jms translation
     */
    public static function getTranslationMessages()
    {
        return [
            new Message('widget.form.theme.widgetslider'),
            new Message('widget.widgetslider.new.action.label', 'victoire'),
        ];
    }
}
