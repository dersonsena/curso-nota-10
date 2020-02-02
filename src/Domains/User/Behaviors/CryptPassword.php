<?php

namespace App\Domains\User\Behaviors;

use Yii;
use App\Domains\User\User;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CryptPassword extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'find',
            ActiveRecord::EVENT_BEFORE_INSERT => 'insert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'update'
        ];
    }

    public function find()
    {
        /** @var User $owner */
        $owner = $this->owner;

        if ($owner->isNewRecord) {
            return;
        }

        $owner->currentPassword = $owner->password;
    }

    public function insert()
    {
        /** @var User $owner */
        $owner = $this->owner;
        $owner->password = Yii::$app->getSecurity()->generatePasswordHash($owner->password);
    }

    public function update()
    {
        /** @var User $owner */
        $owner = $this->owner;

        if (empty($owner->password)) {
            $owner->password = $owner->currentPassword;
            return;
        }

        if (strlen($owner->password) >= 60) {
            return;
        }

        $owner->password = Yii::$app->getSecurity()->generatePasswordHash($owner->password);
    }
}
