<?php

namespace App\Domains\Client;

use App\Domains\Bill\Bill;
use App\Infra\ActiveRecord\ActiveRecordAbstract;
use App\Infra\ActiveRecord\Validators\CpfCnpjValidator;

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
            ['name', 'required'],
            ['email', 'email'],
            [['status', 'deleted'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'email', 'address_street', 'address_neighborhood', 'address_complement'], 'string', 'max' => 60],
            [['cpf', 'phone_home', 'phone_cell', 'phone_commercial'], 'string', 'max' => 11],
            [['address_number', 'address_zipcode'], 'string', 'max' => 10],
            [['created_by', 'updated_by', 'deleted_by'], 'string', 'max' => 100],
            ['cpf', CpfCnpjValidator::class],
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
}
