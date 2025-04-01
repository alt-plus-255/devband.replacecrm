<?php

namespace DevBand\ReplaceCrm\Crm\Service\Operation\Action\Before;

use Bitrix\Crm\Item;
use Bitrix\Main\Result;
use Bitrix\Crm\Service\Operation\Action;
use Bitrix\Main\Event;

class Delete extends Action
{
    /**
     * @param Item $item
     * @return Result
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function process(Item $item): Result
    {
        \Bitrix\Main\Loader::includeModule("devband.replacecrm");

        $result = new Result();

        $event = new Event('crm', 'replace_before_onCrmDynamicItemDelete', [
            'item' => $item
        ]);
        $event->send();

        return $result;
    }
}