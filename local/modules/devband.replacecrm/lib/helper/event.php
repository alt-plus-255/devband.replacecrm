<?php

namespace DevBand\ReplaceCrm\Helper;

class Event
{

    /**
     * @param string $eventName
     * @param array $parameters
     * @return \Bitrix\Main\Event
     */
    public static function send(string $eventName, array $parameters = []): \Bitrix\Main\Event
    {
        $event = new \Bitrix\Main\Event(
            "devband.replacecrm",
            $eventName,
            $parameters
        );

        $event->send();

        return $event;
    }

}