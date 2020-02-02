<?php

namespace App\Application\Controller;

use yii\web\Controller;

abstract class ControllerBase extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
}
