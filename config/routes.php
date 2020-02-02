<?php

use App\Application\Http\Auth\AuthController;
use App\Application\Http\Bill\BillsController;
use App\Application\Http\Client\ClientsController;
use App\Application\Http\Dashboard\DashboardController;

return [
    'controllerMap' => [
        'auth' => AuthController::class,
        'dashboard' => DashboardController::class,
        'clients' => ClientsController::class,
        'bills' => BillsController::class
    ],
    'routes' => [
         '/' => 'auth/login',
         '/auth/login' => 'auth/login',
         '/auth/logout' => 'auth/logout',

        '/dashboard' => 'dashboard/index',

        '/clients' => 'clients/index',
        '/clients/create' => 'clients/create',
        '/clients/update/{id}' => 'clients/update',
        '/clients/view/{id}' => 'clients/view',
        '/clients/delete/{id}' => 'clients/delete',

        '/bills' => 'bills/index',
        '/bills/create' => 'bills/create',
        '/bills/update/{id}' => 'bills/update',
        '/bills/view/{id}' => 'bills/view',
        '/clients/cancel/{id}' => 'clients/cancel',

        // To create a standalone route with more configurations:
        /*[
            'pattern' => 'pattern/to/your/route',
            'route' => 'controller-id/action-id',
            'verb' => ['GET']
        ]*/

        // To create a Active route (Active Controller):
        /*[
            'class' => 'yii\rest\UrlRule',
            'controller' => 'controller-id',
            //'pluralize' => true,
            'extraPatterns' => [
                'GET test' => 'test',
            ],
        ]*/
    ]
];
