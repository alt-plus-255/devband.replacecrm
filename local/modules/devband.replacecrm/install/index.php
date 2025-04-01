<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class devband_replacecrm extends CModule
{
    const MODULE_ID = "devband.replacecrm";
    var $MODULE_ID = "devband.replacecrm";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $strError = "";

    public function __construct()
    {
        $arModuleVersion = array();
        include_once(__DIR__ . "/version.php");

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("DEV_BAND_MODULE_REPLACE_CRM");
        $this->MODULE_DESCRIPTION = Loc::getMessage("DEV_BAND_DESCRIPTION_REPLACE_CRM");

        $this->PARTNER_URI = Loc::getMessage("DEV_BAND_PARTNER_URI_REPLACE_CRM");
        $this->PARTNER_NAME = Loc::getMessage("DEV_BAND_PARTNER_NAME_REPLACE_CRM");
    }

    public function DoInstall()
    {
        global $APPLICATION;
        $this->InstallEvents();
        RegisterModule(self::MODULE_ID);
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        UnRegisterModule(self::MODULE_ID);
        $this->UnInstallEvents();
    }

    function InstallDB()
    {
        return true;
    }

    public function InstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();

        $eventManager->registerEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "\\DevBand\\ReplaceCrm\\Event\\Main",
            "OnProlog",
            50
        );

        $eventManager->registerEventHandler(
            "crm",
            "onEntityDetailsTabsInitialized",
            $this->MODULE_ID,
            "\\DevBand\\ReplaceCrm\\Event\\Crm",
            "onEntityDetailsTabsInitialized",
            99
        );

        return true;
    }

    public function UnInstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            "main",
            "OnProlog",
            $this->MODULE_ID,
            "\\DevBand\\ReplaceCrm\\Event\\Main",
            "OnProlog"
        );

        $eventManager->unRegisterEventHandler(
            "crm",
            "onEntityDetailsTabsInitialized",
            $this->MODULE_ID,
            "\\DevBand\\ReplaceCrm\\Event\\Crm",
            "onEntityDetailsTabsInitialized",
        );

        return true;
    }

}