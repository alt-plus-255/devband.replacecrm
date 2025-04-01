<?php

namespace DevBand\ReplaceCrm\Event;

use Bitrix\Main\EventResult;

class Crm
{

    /**
     * Переопределяем события по добавлению табов в сделку для возможности подстановки нескольих таблов из разных модулей в сделку
     * @param \Bitrix\Main\Event $event
     * @return EventResult|void
     */
    public static function onEntityDetailsTabsInitialized(\Bitrix\Main\Event $event)
    {
        $tabs = [];
        $originalTabIds = array_map(function ($tab) {
            return $tab['id'];
        }, $event->getParameter('tabs'));

        $event = new \Bitrix\Main\Event('crm', 'merge_onEntityDetailsTabsInitialized', [
            'entityID' => $event->getParameter('entityID'),
            'entityTypeID' => $event->getParameter('entityTypeID'),
            'guid' => $event->getParameter('guid'),
            'tabs' => $event->getParameter('tabs'),
        ]);
        $event->send();

        foreach ($event->getResults() as $result) {
            if ($result->getType() === EventResult::SUCCESS) {
                $parameters = $result->getParameters();

                if (is_array($parameters) && is_array($parameters['tabs'])) {
                    foreach ($parameters['tabs'] as $tab) {
                        $tabs[$tab['id']] = $tab;
                    }
                }
            }
        }

        $diffTabs = array_diff(array_keys($tabs), $originalTabIds);

        if (sizeof($diffTabs) != 0) {
            return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, [
                'tabs' => array_values($tabs),
            ]);
        }
    }

}