<?php

namespace App\Infra\ActiveRecord;

use App\Infra\ActiveRecord\Behaviors\DateColumnsConvertion;
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
                'value' => (isset(Yii::$app->user) && !Yii::$app->user->getIsGuest()
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
            [
                'class' => DateColumnsConvertion::class
            ]
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

    /**
     * @param string $labelColumn
     * @param string $keyColumn
     * @param string $order
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function dropdownOptions(string $labelColumn, string $keyColumn = 'id', $order = null)
    {
        $model = Yii::$container->get(static::class);

        $query = $model::find()
            ->select([$labelColumn, $keyColumn])
            ->orderBy(!is_null($order) ? $order : $labelColumn . ' ASC');

        if (array_key_exists('status', $model->attributes)) {
            $query->andWhere(['status' => 1]);
        }

        if (array_key_exists('deleted', $model->attributes)) {
            $query->andWhere(['deleted' => 0]);
        }

        return ArrayHelper::map($query->all(), $keyColumn, $labelColumn);
    }
}
