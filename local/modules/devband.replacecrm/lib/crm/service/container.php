<?php

namespace DevBand\ReplaceCrm\Crm\Service;

use Bitrix\Crm\Model\Dynamic\Type;
use Bitrix\Crm\Service\Factory;
use Bitrix\Crm\Service\UserPermissions;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Result;

\Bitrix\Main\Loader::includeModule("crm");
\Bitrix\Main\Loader::includeModule("devband.replacecrm");

final class Container extends \Bitrix\Crm\Service\Container
{
    use \DevBand\ReplaceCrm\Traits\ServiceLocator;

    public function getFactory(int $entityTypeId): ?Factory
    {
        $this->entityTypeId = $entityTypeId;

        $baseFactory = parent::getFactory($entityTypeId);

        $replaceFactory = $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId,
            null,
            true
        );

        if ($baseFactory instanceof \Bitrix\Crm\Service\Factory\Dynamic && is_null($replaceFactory)) {
            if ($type = $this->getTypeByEntityTypeId($entityTypeId)) {
                return new \DevBand\ReplaceCrm\Crm\Service\Factory\Dynamic($type);
            }
        } else {
            return $baseFactory;
        }

        return $replaceFactory;
    }

    public function getUserPermissions(?int $userId = null): UserPermissions
    {
        $event = new Event('devband.replacecrm', 'replace_container_onUserPermissions', [
            'userId' => $userId,
            'entityTypeId' => $this->entityTypeId,
            'result' => &$result
        ]);
        $event->send();

        $result = $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $userId
            ]
        );

        foreach ($event->getResults() as $eventResult) {
            if ($eventResult->getType() === EventResult::SUCCESS) {
                $parameters = $eventResult->getParameters();

                if (isset($parameters['result']) && $parameters['result'] instanceof UserPermissions) {
                    $result = $eventResult;
                }
            }
        }

        return $result;
    }

    public function getTypeByEntityTypeId(int $entityTypeId): ?Type
    {
        $this->entityTypeId = $entityTypeId;

        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ]
        );
    }
}