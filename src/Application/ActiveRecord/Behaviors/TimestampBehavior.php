<?php

namespace App\Application\ActiveRecord\Behaviors;

use yii\behaviors\TimestampBehavior as YiiTimestampBehavior;
use yii\db\BaseActiveRecord;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

class TimestampBehavior extends YiiTimestampBehavior
{
    /**
     * @var string
     */
    public $deletedAtAttribute = 'deleted_at';

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdAtAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
                SoftDeleteBehavior::EVENT_BEFORE_SOFT_DELETE => $this->deletedAtAttribute
            ];
        }
    }
}
