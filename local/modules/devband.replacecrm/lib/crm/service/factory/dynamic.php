<?php

namespace DevBand\ReplaceCrm\Crm\Service\Factory;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\Operation;
use Bitrix\Crm\Service\Operation\Add;
use Bitrix\Crm\Service\Operation\Delete;
use Bitrix\Crm\Service\Operation\Update;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;

Loader::includeModule('crm');

class Dynamic extends \Bitrix\Crm\Service\Factory\Dynamic
{

    public function getAddOperation(
        Item $item,
        Context $context = null
    ): Add {
        Loader::includeModule("devband.replacecrm");

        $operation = parent::getAddOperation($item, $context);

        $operation
            ->addAction(
                Operation::ACTION_BEFORE_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\Before\Add
            );

        $operation
            ->addAction(
                Operation::ACTION_AFTER_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\After\Add
            );

        $event = new Event('devband.replacecrm', 'replace_dynamic_onAddOperation', [
            'item' => &$item,
            'context' => &$context,
            'operation' => &$operation
        ]);
        $event->send();

        return $operation;
    }

    public function getDeleteOperation(
        Item $item,
        Context $context = null
    ): Delete {
        Loader::includeModule("devband.replacecrm");

        $operation = parent::getDeleteOperation($item, $context);

        $operation
            ->addAction(
                Operation::ACTION_BEFORE_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\Before\Delete
            );

        $operation
            ->addAction(
                Operation::ACTION_AFTER_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\After\Delete
            );

        $event = new Event('devband.replacecrm', 'replace_dynamic_onDeleteOperation', [
            'item' => &$item,
            'context' => &$context,
            'operation' => &$operation
        ]);
        $event->send();

        return $operation;
    }

    public function getUpdateOperation(
        Item $item,
        Context $context = null
    ): Update {
        Loader::includeModule("devband.replacecrm");

        $operation = parent::getUpdateOperation($item, $context);

        $operation
            ->addAction(
                Operation::ACTION_BEFORE_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\Before\Update
            );

        $operation
            ->addAction(
                Operation::ACTION_AFTER_SAVE,
                new \DevBand\ReplaceCrm\Crm\Service\Operation\Action\After\Update
            );

        $event = new Event('devband.replacecrm', 'replace_dynamic_onUpdateOperation', [
            'item' => &$item,
            'context' => &$context,
            'operation' => &$operation
        ]);
        $event->send();

        return $operation;
    }

}