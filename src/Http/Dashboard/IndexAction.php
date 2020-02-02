<?php

namespace App\Http\Dashboard;

use yii\base\Action;

class IndexAction extends Action
{
    public function run()
    {
        return $this->controller->render('index');
    }
}
