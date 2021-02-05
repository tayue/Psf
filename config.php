<?php

use Psf\Bean\Person;

return [
    'server' => [
        'host' => '0.0.0.0',
        'port' => 9501,
    ],
    'beans' => [
        'person' => [
            'class' => Person::class,
            'constructor' => ['name' => 'tayueliuxiang']
        ]
    ],
    'routeMap' => [
        'show' => [['GET', 'POST'], '/user/{id:\d+}', Psf\Test\App\Controller\BlogController::class . '@show'],
        'test' => [['GET', 'POST'], '/test', Psf\Test\App\Controller\BlogController::class . '@test'],
    ]
];
