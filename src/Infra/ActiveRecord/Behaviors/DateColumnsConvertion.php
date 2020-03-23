<?php

namespace App\Infra\ActiveRecord\Behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class DateColumnsConvertion extends Behavior
{
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'run'
        ];
    }

    public function run($event)
    {
        $columns = $this->owner->getTableSchema()->columns;

        foreach ($columns as $name => $schema) {
            if ($schema->type !== 'date') {
                continue;
            }

            if ($schema->type === 'date') {
                $this->owner->{$name} = Yii::$app->getFormatter()->asDate($this->owner->{$name});
                continue;
            }

            if (in_array($schema->type, ['datetime', 'timestamp'])) {
                $this->owner->{$name} = Yii::$app->getFormatter()->asDatetime($this->owner->{$name});
            }
        }
    }
}
