<?php

namespace App\Application\Controller;

use yii\filters\AccessControl;
use yii\web\Controller;

abstract class ControllerBase extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }
}
