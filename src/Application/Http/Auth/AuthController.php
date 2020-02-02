<?php

namespace App\Application\Http\Auth;

use App\Application\Controller\ControllerBase;

class AuthController extends ControllerBase
{
    public function actions()
    {
        return [
            'login' => LoginAction::class,
            'logout' => LogoutAction::class
        ];
    }
}
