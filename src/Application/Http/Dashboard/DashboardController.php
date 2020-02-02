<?php

namespace App\Application\Http\Dashboard;

use App\Application\Controller\ControllerBase;
use yii\web\ErrorAction;

class DashboardController extends ControllerBase
{
    public function actions()
    {
        return [
            'index' => IndexAction::class,
            'error' => ErrorAction::class
        ];
    }
}
