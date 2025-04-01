<?php

namespace DevBand\ReplaceCrm\Helper\Crm\Service;

use Bitrix\Crm\Service\Router\ParseResult;
use Bitrix\Main\DI\ServiceLocator;

class Router
{

    public static function parseRequest(ParseResult $result = null): array
    {
        $router = ServiceLocator::getInstance()
            ->get('crm.service.router');

        $componentParameters = $result->getComponentParameters() ?? $router->getDefaultComponentParameters();

        return [
            'componentName' => $result->getComponentName() ?? $router->getDefaultComponent(),
            'componentParameters' => $componentParameters,
            'componentTemplate' => $result->getTemplateName() ?? '',
            'entityTypeId' => $componentParameters['ENTITY_TYPE_ID'] ?? $componentParameters['entityTypeId'] ?? null
        ];
    }

}