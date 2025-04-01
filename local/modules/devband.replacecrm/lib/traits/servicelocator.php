<?php

namespace DevBand\ReplaceCrm\Traits;

use Bitrix\Main\ObjectNotFoundException;
use Psr\Container\NotFoundExceptionInterface;

trait ServiceLocator
{

    public ?int $entityTypeId = null;

    /**
     * Метод подменяющий стандартный метод на метод сервиса
     * @param string $method
     * @param array $parameters
     * @param int|null $entityTypeId
     * @param string|null $serviceName
     * @return mixed
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     */
    protected function replaceServiceMethod(
        string $method,
        array $parameters = [],
        int $entityTypeId = null,
        string $serviceName = null,
        bool $returnNull = false
    ) {
        if (is_null($entityTypeId)) {
            $entityTypeId = $this->entityTypeId;
        }

        if ($service = self::methodExistsService($method, $entityTypeId, $serviceName)) {
            return $service->$method(
                ...$parameters
            );
        }

        if (!$returnNull) {
            return parent::$method(...$parameters);
        }
        return null;
    }

    /**
     * Метод подменяющий стандартный статический метод на метод сервиса
     * @param string $method
     * @param array $parameters
     * @param int|null $entityTypeId
     * @param string|null $serviceName
     * @return mixed
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     */
    protected static function replaceServiceMethodStatic(
        string $method,
        array $parameters = [],
        int $entityTypeId = null,
        string $serviceName = null
    ) {
        if ($service = self::methodExistsService($method, $entityTypeId, $serviceName)) {
            return $service::$method(
                ...$parameters
            );
        }

        return parent::$method(...$parameters);
    }

    /**
     * Определяет класс из которого вызывается метод и приводит его в нижнему регистру
     * @return string
     */
    private static function classNameService(): string
    {
        $className = explode('\\', static::class);
        $className = end($className);
        return mb_strtolower($className);
    }

    /**
     * Формирует название сервиса
     * @param int|null $entityTypeId
     * @return string
     */
    protected static function getServiceName(int $entityTypeId = null): string
    {
        $className = self::classNameService();

        return sprintf(
            'replace.crm.service.%s.%s',
            $className,
            $entityTypeId
        );
    }

    /**
     * Формирует название сервиса
     * @param int|null $entityTypeId
     * @return string
     */
    protected static function getFilterServiceName(int $entityTypeId = null): string
    {
        $className = self::classNameService();

        return sprintf(
            'replace.crm.filter.%s.%s',
            $className,
            $entityTypeId
        );
    }

    /**
     * Проверяем есть ли сервис и метод для переопределения
     * @param string $method
     * @param int|null $entityTypeId
     * @param string|null $serviceName
     * @return mixed|string|null
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     */
    private static function methodExistsService(string $method, int $entityTypeId = null, string $serviceName = null)
    {
        $serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();

        if (is_null($serviceName)) {
            $serviceName = self::getServiceName($entityTypeId);
        }

        if ($serviceLocator->has($serviceName)) {
            $service = $serviceLocator->get($serviceName);

            if (method_exists($service, $method)) {
                return $service;
            }
        }

        return null;
    }

}