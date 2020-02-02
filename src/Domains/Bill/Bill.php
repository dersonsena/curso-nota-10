<?php

namespace App\Domains\Bill;

use App\Domains\Client\Client;
use App\Infra\ActiveRecord\ActiveRecordAbstract;

/**
 * This is the model class for table "{{%bills}}".
 *
 * @property int $id
 * @property int $client_id
 * @property string $type
 * @property string $status
 * @property string $description
 * @property string $emission_date
 * @property string $due_date
 * @property string $amount
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
            [['client_id', 'description', 'emission_date', 'due_date', 'amount'], 'required'],
            ['client_id', 'integer'],
            [['type', 'status', 'observations', 'cancellation_reason'], 'string'],
            [
                [
                    'emission_date',
                    'due_date',
                    'payment_date',
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
            [['emission_date', 'due_date'], 'date'],
            [['payment_date', 'cancellation_date'], 'datetime']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->buildAttributeLabels([
            'client_id' => 'Cliente',
            'type' => 'Tipo',
            'status' => 'Status',
            'description' => 'Descrição',
            'emission_date' => 'Data Emissão',
            'due_date' => 'Data Vencimento',
            'amount' => 'Valor',
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

    public static function getStatusList(): array
    {
        return [
            static::STATUS_OPEN => 'Aberto',
            static::STATUS_RECEIVED => 'Recebido',
            static::STATUS_CANCELLED => 'Cancelado',
        ];
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
        return static::getTypeAsText()[$this->type];
    }
}
