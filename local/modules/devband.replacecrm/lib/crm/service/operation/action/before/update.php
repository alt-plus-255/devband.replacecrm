<?php

namespace DevBand\ReplaceCrm\Crm\Service\Operation\Action\Before;

use Bitrix\Crm\Item;
use Bitrix\Main\EventResult;
use Bitrix\Main\Result;
use Bitrix\Crm\Service\Operation\Action;
use Bitrix\Main\Event;

class Update extends Action
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

        $event = new Event('devband.replacecrm', 'replace_before_onCrmDynamicItemUpdate', [
            'item' => $item,
            'result' => &$result
        ]);
        $event->send();

        foreach ($event->getResults() as $eventResult) {
            if ($eventResult->getType() === EventResult::ERROR) {
                $parameters = $eventResult->getParameters();

                if (isset($parameters['result']) && $parameters['result'] instanceof Result) {
                    $result = $eventResult;
                }
            }
        }

        return $result;
    }
}