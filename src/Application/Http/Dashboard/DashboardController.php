<?php

namespace App\Application\Http\Dashboard;

use App\Application\Controller\ControllerBase;

class DashboardController extends ControllerBase
{
    public function actions()
    {
        return [
            'index' => IndexAction::class
        ];
    }
}
