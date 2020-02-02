<?php

namespace App\Application\ActiveRecord\Behaviors;

use yii\behaviors\BlameableBehavior as YiiBlameableBehavior;
use yii\db\BaseActiveRecord;

class BlameableBehavior extends YiiBlameableBehavior
{
    /**
     * @var string the attribute that will receive current user ID value
     * Set this property to false if you do not want to record the updater ID.
     */
    public $deletedByAttribute = 'deleted_by';

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->createdByAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedByAttribute,
                BaseActiveRecord::EVENT_BEFORE_DELETE => $this->deletedByAttribute
            ];
        }
    }
}
