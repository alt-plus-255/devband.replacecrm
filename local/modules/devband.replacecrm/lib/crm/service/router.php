<?php

namespace DevBand\ReplaceCrm\Crm\Service;

use Bitrix\Crm\ItemIdentifier;
use Bitrix\Crm\Service\Router\ParseResult;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Web\Uri;

\Bitrix\Main\Loader::includeModule("crm");
\Bitrix\Main\Loader::includeModule("devband.replacecrm");

class Router extends \Bitrix\Crm\Service\Router
{
    use \DevBand\ReplaceCrm\Traits\ServiceLocator;

    public const SYSTEM_PAGE_CODES = [
        \CCrmOwnerType::Activity => 'activity',
    ];

    /**
     * Внимательно изучаем метод и логику его работы, прежде чем возвращать данные в наследниках!
     * @return array|array[]
     */
    public function getTemplatesForJsRouter(): array
    {
        $parent = parent::getTemplatesForJsRouter();

        $event = \DevBand\ReplaceCrm\Helper\Event::send(
            'onReplaceGetTemplatesForJsRouter',
            [
                'parent' => &$parent
            ]
        );

        //todo: Проверить
        foreach ($event as $item) {
        }

        return $parent;
    }

    public function parseRequest(HttpRequest $httpRequest = null): ParseResult
    {
        $result = parent::parseRequest($httpRequest);

        $componentParameters = $result->getComponentParameters() ?? $this->getDefaultComponentParameters();

        $entityTypeId = $componentParameters['ENTITY_TYPE_ID'] ?? $componentParameters['entityTypeId'] ?? null;

        if ($entityTypeId) {
            $entityTypeId = intval($entityTypeId);

            return $this->replaceServiceMethod(
                __FUNCTION__,
                [
                    $httpRequest,
                    $result,
                    $entityTypeId
                ],
                $entityTypeId
            );
        }

        return $result;
    }

    public function getTypeDetailUrl(int $entityTypeId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getItemListUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getItemListUrlIntoCustomSection(
        string $customSectionCode,
        int $entityTypeId,
        ?int $categoryId = null
    ): ?Uri {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $customSectionCode,
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getKanbanUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getKanbanUrlIntoCustomSection(
        string $customSectionCode,
        int $entityTypeId,
        ?int $categoryId = null
    ): ?Uri {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $customSectionCode,
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getSystemPageCode(int $entityTypeId): ?string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getActivityUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getDeadlinesUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getReportsUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getCalendarUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getItemDetailUrlCompatibleTemplate(int $entityTypeId): ?string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getItemDetailUrl(
        int $entityTypeId,
        int $id = 0,
        int $categoryId = null,
        ?ItemIdentifier $parentItemIdentifier = null
    ): ?Uri {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $id,
                $categoryId,
                $parentItemIdentifier
            ],
            $entityTypeId
        );
    }

    public function isNewRoutingForListEnabled(int $entityTypeId): bool
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function isNewRoutingForDetailEnabled(int $entityTypeId): bool
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function isNewRoutingForAutomationEnabled(int $entityTypeId): bool
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getMobileItemDetailUrl(int $entityTypeId, int $id = 0): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $id
            ],
            $entityTypeId
        );
    }

    public function getItemCopyUrl(int $entityTypeId, int $id = 0, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $id,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getUserFieldListUrl(int $entityTypeId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getUserFieldDetailUrl(int $entityTypeId, int $fieldId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $fieldId
            ],
            $entityTypeId
        );
    }

    public function getCategoryListUrl(int $entityTypeId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getItemListUrlInCurrentView(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function setCurrentListView(int $entityTypeId, string $view): \Bitrix\Crm\Service\Router
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $view
            ],
            $entityTypeId
        );
    }

    public function getCurrentListView(int $entityTypeId): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getDefaultListView(int $entityTypeId): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function setDefaultListView(int $entityTypeId, string $view): void
    {
        $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $view
            ],
            $entityTypeId
        );
    }

    public function getCurrentListViewInCustomSection(int $entityTypeId, string $customSectionCode): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $customSectionCode
            ],
            $entityTypeId
        );
    }

    public function setCurrentListViewInCustomSection(int $entityTypeId, string $customSectionCode, string $view): self
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $customSectionCode,
                $view
            ],
            $entityTypeId
        );
    }

    public function getEntityViewNameInCustomSection(int $entityTypeId, string $customSectionCode): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $customSectionCode
            ],
            $entityTypeId
        );
    }

    public function getAutomationUrlTemplate(int $entityTypeId): ?string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getAutomationUrl(int $entityTypeId, int $categoryId = null): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $categoryId
            ],
            $entityTypeId
        );
    }

    public function getFileUrlTemplate(int $entityTypeId): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getFileUrl(int $entityTypeId, int $id, string $fieldName, int $fileId): Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $id,
                $fieldName,
                $fileId
            ],
            $entityTypeId
        );
    }

    public function getChildrenItemsListUrl(int $entityTypeId, int $parentEntityTypeId, int $parentEntityId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $parentEntityTypeId,
                $parentEntityId
            ],
            $entityTypeId
        );
    }

    public function getItemListSliderUrl(int $entityTypeId): ?Uri
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function signChildrenItemsComponentParams(int $entityTypeId, array $componentParams): string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $componentParams
            ],
            $entityTypeId
        );
    }

    public function unsignChildrenItemsComponentParams(int $entityTypeId, string $signedComponentParams): ?array
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId,
                $signedComponentParams
            ],
            $entityTypeId
        );
    }

    public function getItemDetailComponentName(int $entityTypeId): ?string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public function getItemListComponentName(int $entityTypeId): ?string
    {
        return $this->replaceServiceMethod(
            __FUNCTION__,
            [
                $entityTypeId
            ],
            $entityTypeId
        );
    }

    public static function resolveComponentEngineCallback(
        \CComponentEngine $engine,
        array $pageCandidates,
        array &$pageVariables
    ) {
        foreach ($pageCandidates as $componentName => $componentParams) {
            $entityTypeId = (int)($componentParams['ENTITY_TYPE_ID'] ?? \CCrmOwnerType::Undefined);
            if ($entityTypeId !== 0) {
                return self::replaceServiceMethodStatic(
                    __FUNCTION__,
                    [
                        $engine,
                        $pageCandidates,
                        $pageVariables
                    ],
                    $entityTypeId
                );
            }
        }
    }

}