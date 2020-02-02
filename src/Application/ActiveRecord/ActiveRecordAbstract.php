<?php

namespace App\Application\ActiveRecord;

use Yii;
use DateTime;
use App\Application\ActiveRecord\Behaviors\BlameableBehavior;
use App\Application\ActiveRecord\Behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

abstract class ActiveRecordAbstract extends ActiveRecord
{
    use AttributeLabels, AttributeNames;

    public static function find()
    {
        $query = parent::find();
        $columns = static::getTableSchema()->columns;

        if (array_key_exists('deleted', $columns)) {
            $query->andWhere(static::tableName() . '.`deleted` = 0');
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => $this->getCreatedAtAttribute(),
                'updatedAtAttribute' => $this->getUpdatedAtAttribute(),
                'deletedAtAttribute' => $this->getDeletedAtAttribute(),
                'value' => (new DateTime)->format('Y-m-d H:i:s'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => $this->getCreatedByAttribute(),
                'updatedByAttribute' => $this->getUpdatedByAttribute(),
                'deletedByAttribute' => $this->getDeletedByAttribute(),
                'value' => (isset(Yii::$app->user)
                    ? Yii::$app->user->identity->name . ' [' . Yii::$app->user->id . ']'
                    : null
                )
            ],
            [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [$this->deletedAttribute => true],
            ],
        ]);
    }

    /**
     * Generate the active record formatted errors
     * @return array
     */
    public function getFormattedErrors(): array
    {
        if (empty($this->errors)) {
            return [];
        }

        $formattedErrors = [];

        foreach ($this->errors as $columnName => $errorList) {
            $formattedErrors[] = [
                'field' => $columnName,
                'message' => $errorList[0]
            ];
        }

        return $formattedErrors;
    }
}
