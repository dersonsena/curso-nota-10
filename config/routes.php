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
        '/clients/update/<id:\d+>' => 'clients/update',
        '/clients/view/<id:\d+>' => 'clients/view',
        '/clients/delete/<id:\d+>' => 'clients/delete',
        '/clients/import' => 'clients/import',

        '/bills' => 'bills/index',
        '/bills/create' => 'bills/create',
        '/bills/update/<id:\d+>' => 'bills/update',
        '/bills/view/<id:\d+>' => 'bills/view',
        '/clients/cancel/<id:\d+>' => 'clients/cancel',

        // To create a standalone route with more configurations:
        /*[
            'pattern' => 'pattern/to/your/route',
            'route' => 'controller-id/action-id',
            'verb' => ['GET']
        ]*/
    ]
];
