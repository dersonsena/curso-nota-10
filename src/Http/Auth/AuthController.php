<?php

namespace App\Http\Auth;

use App\Core\Controller\ControllerBase;

class AuthController extends ControllerBase
{
    public function actions()
    {
        return [
            'login' => LoginAction::class,
            'logout' => LoginAction::class
        ];
    }
}
