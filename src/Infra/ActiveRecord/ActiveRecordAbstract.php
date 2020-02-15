<?php

namespace App\Infra\ActiveRecord;

use Yii;
use DateTime;
use App\Infra\ActiveRecord\Behaviors\BlameableBehavior;
use App\Infra\ActiveRecord\Behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

abstract class ActiveRecordAbstract extends ActiveRecord
{
    use AttributeLabels, AttributeNames;

    /**
     * @param bool $singularize
     * @return string
     */
    abstract public static function getEntityDescription(bool $singularize = false): string;

    public function init()
    {
        $this->loadDefaultValues();
        return parent::init();
    }

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
                'softDeleteAttributeValues' => [
                    $this->deletedAttribute => true
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getErrorsToHTMLList(): string
    {
        $errors = $this->getErrors();
        $output = '<ul style="padding: 9px 0 0 16px;">';

        foreach ($errors as $listErrors) {
            foreach ($listErrors as $error) {
                $output .= '<li>'. $error .'</li>';
            }
        }

        $output .= '</ul>';

        return $output;
    }
}
