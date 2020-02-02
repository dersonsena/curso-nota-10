<?php

namespace App\Domains\User\Behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class RefreshAuthKey extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'run',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'run'
        ];
    }

    public function run()
    {
        $this->owner->updateAttributes([
            'auth_key' => Yii::$app->getSecurity()->generateRandomString()
        ]);
    }
}
