<?php

namespace App\Domains\Client;

use App\Infra\ActiveRecord\Validators\CpfCnpjValidator;
use yii\data\ActiveDataProvider;

class ClientSearch extends Client
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 60],
            ['email', 'email'],
            ['cpf', CpfCnpjValidator::class],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = Client::find()
            ->orderBy('name ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
