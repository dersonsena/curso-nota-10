<?php

namespace App\Domains\Bill;

use App\Domains\Client\Client;
use App\Infra\ActiveRecord\ActiveRecordAbstract;
use Yii;

/**
 * This is the model class for table "{{%bills}}".
 *
 * @property int $id
 * @property int $client_id
 * @property int $bill_parent_id
 * @property string $type
 * @property string $status
 * @property string $description
 * @property string $due_date
 * @property string $amount
 * @property integer $parcel_number
 * @property string $observations
 * @property string $payment_date
 * @property string $payment_user
 * @property string $cancellation_date
 * @property string $cancellation_reason
 * @property string $cancellation_user
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 *
 * @property Client $client
 */
class Bill extends ActiveRecordAbstract
{
    const TYPE_INCOME = 1;
    const TYPE_EXPENSE = 2;

    const STATUS_OPEN = 1;
    const STATUS_RECEIVED = 2;
    const STATUS_CANCELLED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bills}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'description', 'due_date', 'amount', 'status'], 'required'],
            [['client_id', 'bill_parent_id', 'parcel_number'], 'integer'],
            [['type', 'status', 'observations', 'cancellation_reason'], 'string'],
            [
                [
                    'payment_date',
                    'cancellation_date',
                    'cancellation_date',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ],
                'safe'
            ],
            ['amount', 'number'],
            ['description', 'string', 'max' => 60],
            [['payment_user', 'cancellation_user', 'created_by', 'updated_by', 'deleted_by'], 'string', 'max' => 100],
            [
                'client_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Client::class,
                'targetAttribute' => ['client_id' => 'id']
            ],
            [
                'bill_parent_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Bill::class,
                'targetAttribute' => ['bill_parent_id' => 'id']
            ],
            [['payment_date', 'cancellation_date'], 'datetime'],
            ['due_date', 'filter', 'filter' => function ($value) {
                return Yii::$app->getFormatter()->asDateUS($value);
            }]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->buildAttributeLabels([
            'client_id' => 'Titular',
            'bill_parent_id' => 'Conta Pai',
            'type' => 'Tipo',
            'status' => 'Status',
            'description' => 'Descrição',
            'due_date' => 'Data Vencimento',
            'amount' => 'Valor',
            'parcel_number' => 'Nº Parcela',
            'observations' => 'Observações',
            'payment_date' => 'Data Pagamento',
            'payment_user' => 'Usuário da Baixa',
            'cancellation_date' => 'Data Cancelamento',
            'cancellation_reason' => 'Motivo Cancelamento',
            'cancellation_user' => 'Usuário que Cancelou',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getBill()
    {
        return $this->hasOne(Bill::class, ['id' => 'bill_parent_id']);
    }

    public function getBills()
    {
        return $this->hasMany(Bill::class, ['id' => 'bill_parent_id']);
    }

    public static function getStatusList(array $exept = []): array
    {
        $list = [
            static::STATUS_OPEN => 'Aberto',
            static::STATUS_RECEIVED => 'Recebido',
            static::STATUS_CANCELLED => 'Cancelado',
        ];

        if (empty($exept)) {
            return $list;
        }

        foreach ($exept as $status) {
            unset($list[$status]);
        }

        return $list;
    }

    public static function getTypesList(): array
    {
        return [
            static::TYPE_INCOME => 'À Receber',
            static::TYPE_EXPENSE => 'À Pagar',
        ];
    }

    public function getStatusAsText(): string
    {
        return static::getStatusList()[$this->status];
    }

    public function getTypeAsText(): string
    {
        return static::getTypesList()[$this->type];
    }

    public function getStatusAsLabel(): string
    {
        $cssClass = '';
        $icon = '';

        switch ($this->status) {
            case static::STATUS_OPEN:
                $cssClass = 'warning';
                $icon = 'glyphicon glyphicon-warning-sign';
                break;
            case static::STATUS_RECEIVED:
                $cssClass = 'success';
                $icon = 'glyphicon glyphicon-ok';
                break;
            case static::STATUS_CANCELLED:
                $cssClass = 'danger';
                $icon = 'glyphicon glyphicon-remove';
                break;
        }

        return '<span style="font-size: 12px" class="label label-'. $cssClass .'">
            <i class="'. $icon .'"></i> '. $this->getStatusAsText() .
        '</span>';
    }

    /**
     * @inheritDoc
     */
    public static function getEntityDescription(bool $singularize = false): string
    {
        return ($singularize === true ? 'Conta' : 'Contas');
    }
}
