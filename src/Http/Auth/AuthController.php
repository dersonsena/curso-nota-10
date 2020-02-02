<?php

namespace App\Http\Auth;

use App\Application\Controller\ControllerBase;

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
