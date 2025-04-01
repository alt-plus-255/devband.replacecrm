<?php

namespace DevBand\ReplaceCrm\Event;

class Main
{

    public static function OnProlog()
    {
        if (class_exists('\Bitrix\Main\DI\ServiceLocator')) {
            $serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();

            $services = \Bitrix\Main\Config\Configuration::getInstance('devband.replacecrm')
                ->get('services');

            $modules = array_filter(
                array_map(
                    static fn($module) => $module['ID'],
                    \Bitrix\Main\ModuleTable::getList()->fetchAll()
                ),
                static fn($module) => $module !== 'devband.replacecrm'
            );

            /**
             * Инициируем сервисы для сервис - локатора всех модулей
             */
            foreach ($modules as $module) {
                $moduleSettings = \Bitrix\Main\Config\Configuration::getInstance($module);

                $moduleSettings->get('services');
            }

            foreach ($services as $serviceName => $data) {
                $serviceClassName = $data['className'];

                if ($serviceClassName) {
                    $serviceLocator
                        ->addInstance(
                            $serviceName,
                            new $serviceClassName
                        );
                }
            }

            unset($serviceLocator);
        }
    }
}