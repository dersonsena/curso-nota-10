<?php

return [
     '/' => 'auth/login',
     '/auth/login' => 'auth/login',
     '/auth/logout' => 'auth/logout',

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
];