<?php

namespace DevBand\ReplaceCrm\Crm\Service;

use Bitrix\Crm\Model\Dynamic\Type;
use Bitrix\Crm\Service\Factory;
use Bitrix\Crm\Service\UserPermissions;

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
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $userId
            ]
        );
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