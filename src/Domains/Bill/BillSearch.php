<?php

namespace App\Domains\Bill;

use yii\helpers\ArrayHelper;

class BillSearch extends Bill
{
    /**
     * @var string
     */
    public $dueDateStart;

    /**
     * @var string
     */
    public $dueDateEnd;

    public function init()
    {
        parent::init();

        $monthYear = date('m') . '/' . date('Y');
        $this->dueDateStart = "01/{$monthYear}";
        $this->dueDateEnd = date('t') . '/' . $monthYear;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['dueDateStart', 'dueDateEnd'], 'required'],
            ['description', 'string', 'max' => 60],
            [['client_id', 'status'], 'integer'],
            [['due_date', 'dueDateStart', 'dueDateEnd'], 'date', 'format' => 'd/m/Y']
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'Nº',
            'dueDateStart' => 'Vencimento Início',
            'dueDateEnd' => 'Vencimento Fim',
        ]);
    }
}
