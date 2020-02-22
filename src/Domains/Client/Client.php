<?php

namespace App\Domains\Client;

use App\Domains\Bill\Bill;
use App\Infra\ActiveRecord\ActiveRecordAbstract;
use App\Infra\ActiveRecord\Validators\CpfCnpjValidator;
use App\Infra\ActiveRecord\Validators\RemoveSymbolsFilter;

/**
 * This is the model class for table "{{%clients}}".
 *
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property string $phone_home
 * @property string $phone_cell
 * @property string $phone_commercial
 * @property string $address_street
 * @property string $address_number
 * @property string $address_neighborhood
 * @property string $address_zipcode
 * @property string $address_complement
 * @property int $status
 * @property int $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 *
 * @property Bill[] $bills
 */
class Client extends ActiveRecordAbstract
{
    /**
     * @var string
     */
    const TYPE_INDIVIDUAL = 1;

    /**
     * @var string
     */
    const TYPE_COMPANY = 2;

    /**
     * @var int
     */
    public $type = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clients}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['email', 'email'],
            [['status', 'deleted'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'email', 'address_street', 'address_neighborhood', 'address_complement'], 'string', 'max' => 60],
            [['cpf', 'phone_home', 'phone_cell', 'phone_commercial'], 'string', 'max' => 17],
            [['address_number', 'address_zipcode'], 'string', 'max' => 10],
            [['created_by', 'updated_by', 'deleted_by'], 'string', 'max' => 100],
            ['type', 'default', 'value' => static::TYPE_INDIVIDUAL],
            ['cpf', CpfCnpjValidator::class, 'cpfType' => static::TYPE_INDIVIDUAL, 'cnpjType' => static::TYPE_COMPANY],
            ['cpf', 'unique'],
            [
                ['cpf', 'phone_home', 'phone_cell', 'phone_commercial', 'address_zipcode'],
                RemoveSymbolsFilter::class
            ],
            [
                [
                    'name', 'email', 'cpf', 'phone_home', 'phone_cell', 'address_street', 'address_neighborhood',
                    'address_complement', 'address_number', 'address_zipcode'
                ],
                'trim'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->buildAttributeLabels([
            'name' => 'Nome',
            'cpf' => 'CPF',
            'type' => 'Tipo',
            'email' => 'E-mail',
            'phone_home' => 'Telefone Res.',
            'phone_cell' => 'Celular',
            'phone_commercial' => 'Telefone Comercial',
            'address_street' => 'Endereço',
            'address_number' => 'Nº',
            'address_neighborhood' => 'Bairro',
            'address_zipcode' => 'CEP',
            'address_complement' => 'Complemento',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::class, ['client_id' => 'id']);
    }

    /**
     * @inheritDoc
     */
    public static function getEntityDescription(bool $singularize = false): string
    {
        return ($singularize === true ? 'Cliente' : 'Clientes');
    }

    /**
     * @return string
     */
    public function getFullAddress(): string
    {
        return (!empty($this->address_street) ? $this->address_street . ', ' : '')
            . (!empty($this->address_number) ? $this->address_number . ' - ' : '')
            . (!empty($this->address_neighborhood) ? $this->address_neighborhood . ' - ' : '')
            . (!empty($this->address_complement) ? $this->address_complement : '') . ' - '
            . (!empty($this->address_zipcode) ? 'CEP: ' . $this->address_zipcode : '');
    }
}
