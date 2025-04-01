<?php

return [
    'services' => [
        'value' => [
            'crm.service.container' => [
                'className' => '\\DevBand\\ReplaceCrm\\Crm\\Service\\Container',
            ],
            'crm.service.router' => [
                'className' => '\\DevBand\\ReplaceCrm\\Crm\\Service\\Router',
            ],
            'crm.filter.factory' => [
                'className' => '\\DevBand\\ReplaceCrm\\Crm\\Filter\\Factory',
            ],
        ]
    ]
];