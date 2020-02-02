<?php

namespace App\Http\Auth;

use Yii;
use yii\base\Action;

class LogoutAction extends Action
{
    public function run()
    {
        Yii::$app->getUser()->logout();

        return $this->controller->redirect(['/auth/login']);
    }
}
