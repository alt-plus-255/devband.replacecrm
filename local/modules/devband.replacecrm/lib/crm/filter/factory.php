<?php

namespace DevBand\ReplaceCrm\Crm\Filter;

use Bitrix\Crm\Filter\Filter;
use Bitrix\Crm\Filter\UserFieldDataProvider;
use Bitrix\Crm\Filter\EntitySettings;
use Bitrix\Main;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Filter\DataProvider;
use Psr\Container\NotFoundExceptionInterface;

\Bitrix\Main\Loader::requireModule('crm');

/**
 * Фабрика для фильтра CRM
 * https://dev.1c-bitrix.ru/api_d7/bitrix/crm/customization/filter.php
 */
class Factory extends \Bitrix\Crm\Filter\Factory
{
    use \DevBand\ReplaceCrm\Traits\ServiceLocator;

    /**
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     */
    public function getSettings(int $entityTypeId, string $filterId, ?array $parameters = []): EntitySettings
    {
        $this->entityTypeId = $entityTypeId;

        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $filterId,
                $parameters
            ],
            $this->entityTypeId,
            $this->getFilterServiceName($entityTypeId)
        );
    }

    /**
     * @param Main\Filter\EntitySettings $settings
     * @return \Bitrix\Main\Filter\DataProvider
     * @throws ObjectNotFoundException
     * @throws \Bitrix\Main\NotSupportedException
     */
    public function getDataProvider(Main\Filter\EntitySettings $settings): DataProvider
    {
        $this->entityTypeId = intval($settings->getEntityTypeID());

        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $settings
            ],
            $this->entityTypeId,
            $this->getFilterServiceName($this->entityTypeId)
        );
    }

    /**
     * Переопределение провайдера по работе с пользовательскими полями
     * @param Main\Filter\EntitySettings $settings
     * @return UserFieldDataProvider|\Bitrix\Main\Filter\DataProvider
     * @throws SystemException
     */
    public function getUserFieldDataProvider(Main\Filter\EntitySettings $settings): DataProvider
    {
        $this->entityTypeId = intval($settings->getEntityTypeID());

        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $settings
            ],
            $this->entityTypeId,
            $this->getFilterServiceName($this->entityTypeId)
        );
    }

    public function getFilter(EntitySettings $settings, ?array $parameters = []): ?Filter
    {
        $this->entityTypeId = intval($settings->getEntityTypeID());

        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $settings,
                $parameters
            ],
            $this->entityTypeId,
            $this->getFilterServiceName($this->entityTypeId)
        );
    }
}
