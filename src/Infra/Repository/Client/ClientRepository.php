<?php

namespace App\Infra\Repository\Client;

use App\Domains\Client\Client;
use App\Infra\Repository\RepositoryAbstract;
use yii\data\ActiveDataProvider;

class ClientRepository extends RepositoryAbstract
{
    /**
     * @inheritDoc
     */
    public function getEntityName(): string
    {
        return Client::class;
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        /** @var Client $model */
        $model = $this->getEntity();

        $query = $model::find()
            ->orderBy('name ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model->load($params);

        if (!$model->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $model->name]);
        $query->andFilterWhere(['like', 'email', $model->email]);
        $query->andFilterWhere(['like', 'cpf', $model->cpf]);

        return $dataProvider;
    }
}
