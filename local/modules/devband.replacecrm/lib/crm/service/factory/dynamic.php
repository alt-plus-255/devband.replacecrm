<?php

namespace DevBand\ReplaceCrm\Crm\Service\Factory;

use Bitrix\Crm\Item;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\Operation;
use Bitrix\Crm\Service\Operation\Delete;
use Bitrix\Main\Loader;

Loader::includeModule('crm');

class Dynamic extends \Bitrix\Crm\Service\Factory\Dynamic
{

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

        return $operation;
    }

}