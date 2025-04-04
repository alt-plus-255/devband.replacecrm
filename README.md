# devband.replacecrm

Смотри актуальную информацию в https://gitverse.ru/altplus255/devband.replacecrm/content/master/README.md

DevBand: ReplaceCrm (Переопределение CRM, СП)

Модуль позволяет определять фабрику, container, router для каждого СП со своим EntityTypeId. 
А также объединять табы в сделка, лидах и СП.

Модуль предназначен для переопределения классов Factory, Container, Router.

В стандартной реализации (в документации) Битрикс предлагает переопределить классы в init.php и работать со всеми сущностями: "Лиды", "Сделки", "Смарт-процессы" там (в файле php_interface/init.php), что приводит к лишним зависимостям и подключению модуля CRM на уровне init.php т.е. везде. 

Данное решение позволит вам как разработчикам разделять классы для разных сущностей в разные модули. 

Например: 
Стоит задача переопределить класс Router для сущности сделки и переопределить класс Container для сущности смарт-процесса с entityTypeId равной 192

Реализация: 
Под каждую сущность вам необходимо создать свой модуль (вместо test указываете название вендора)

1. test.deal
2. test.smart192 (вместо smart192, пишите название вашей сущности смарт-процесса) 

внутри каждого модуля создается файл .settings.php внутри которого пишется след:

1. Для модуля который будет подменять сделку
```php
return [
  'services' => [
    'value' => [
      'replace.crm.service.router.'.\CCrmOwnerType::Deal => new \TEST\Deal\Crm\Service\Router,
    ]
  ]
];
```

2. Для модуля который будет подменять смарт-процесс с entityTypeId = 192
```php
return [
  'services' => [
    'value' => [
      'replace.crm.service.container.'.192 => new \TEST\Smart192\Crm\Service\Container ,
    ]
  ]
];
```

Как вы могли заметить, вам необходимо внутри каждого модуля сделать классы наследующие классы которые вы хотите переопределить.

Также бонусом реализовано событие работы с табами в элементах CRM. По умолчанию битрикс дает подписаться на событие в 1 модуле, если у вас разные модули, которые будут работать с со сделкой и в каждом модуле необходимо вставить свой таб, то используйте событие "merge_onEntityDetailsTabsInitialized" модуля crm, оно позволить выводить табы из нескольких модулей!

События
| Модуль             | Событие                               | Описание                                                                                          | Где посмотреть                                                                      |
|--------------------|---------------------------------------|---------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------|
| crm                | merge_onEntityDetailsTabsInitialized  | Позволяет добавить/объединить таб в элемент сущности модуля CRM из разных модулей                 | local/modules/devband.replacecrm/lib/event/crm.php                                  |
| devband.replacecrm | replace_dynamic_onAddOperation        | Позволяет добавить свои ACTION на операцию по добавлению элемента на все сущности смарт-процессов | local/modules/devband.replacecrm/lib/crm/service/factory/dynamic.php                |
| devband.replacecrm | replace_dynamic_onDeleteOperation     | Позволяет добавить свои ACTION на операцию по удаление элемента на все сущности смарт-процессов   | local/modules/devband.replacecrm/lib/crm/service/factory/dynamic.php                |
| devband.replacecrm | replace_dynamic_onUpdateOperation     | Позволяет добавить свои ACTION на операцию по обновление элемента на все сущности смарт-процессов | local/modules/devband.replacecrm/lib/crm/service/factory/dynamic.php                |
| devband.replacecrm | replace_after_onCrmDynamicItemAdd     | Срабатывает ПОСЛЕ добавления элемента смарт-процесса                                              | local/modules/devband.replacecrm/lib/crm/service/operation/action/after/add.php     |
| devband.replacecrm | replace_after_onCrmDynamicItemDelete  | Срабатывает ПОСЛЕ удаления элемента смарт-процесса                                                | local/modules/devband.replacecrm/lib/crm/service/operation/action/after/delete.php  |
| devband.replacecrm | replace_after_onCrmDynamicItemUpdate  | Срабатывает ПОСЛЕ обновления элемента смарт-процесса                                              | local/modules/devband.replacecrm/lib/crm/service/operation/action/after/update.php  |
| devband.replacecrm | replace_before_onCrmDynamicItemAdd    | Срабатывает ДО добавления элемента смарт-процесса                                                 | local/modules/devband.replacecrm/lib/crm/service/operation/action/before/add.php    |
| devband.replacecrm | replace_before_onCrmDynamicItemDelete | Срабатывает ДО удаления элемента смарт-процесса                                                   | local/modules/devband.replacecrm/lib/crm/service/operation/action/before/delete.php |
| devband.replacecrm | replace_before_onCrmDynamicItemUpdate | Срабатывает ДО обновления элемента смарт-процесса                                                 | local/modules/devband.replacecrm/lib/crm/service/operation/action/before/update.php |
