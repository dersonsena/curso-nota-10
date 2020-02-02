<?php

namespace App\Http\Auth;

use Yii;
use App\Domains\Auth\Forms\Login;
use yii\base\Action;

class LoginAction extends Action
{
    public function run()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->controller->redirect(['/dashboard']);
        }

        /** @var Login $model */
        $model = Yii::$container->get(Login::class);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->controller->goBack();
        }

        $model->password = '';

        return $this->controller->render('login', [
            'model' => $model,
        ]);
    }
}
