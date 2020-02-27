<?php

namespace App\Infra\Forms\Bill;

use App\Domains\Bill\Bill;
use yii\helpers\ArrayHelper;

class Form extends Bill
{
    /**
     * @var bool
     */
    public $hasRegistration;

    /**
     * @var string
     */
    public $registrationAmount;

    /**
     * @var bool
     */
    public $generateBills;

    /**
     * @var int
     */
    public $numberOfBills;

    public function rules()
    {
        return ArrayHelper::merge([
            [['hasRegistration', 'generateBills'], 'boolean'],
            ['registrationAmount', 'number'],
            ['numberOfBills', 'integer']
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'hasRegistration' => 'Receber matrícula.',
            'registrationAmount' => 'Valor Matrícula',
            'generateBills' => 'Gerar contas futuras.',
            'numberOfBills' => 'Nº de Contas',
        ], parent::attributeLabels());
    }
}
