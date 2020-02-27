<?php

namespace App\Infra\Repository\Bill;

use App\Domains\Bill\Bill;
use App\Infra\Repository\RepositoryAbstract;
use yii\data\ActiveDataProvider;

class BillRepository extends RepositoryAbstract
{
    /**
     * @inheritDoc
     */
    public function getEntityName(): string
    {
        return Bill::class;
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        /** @var Bill $model */
        $model = $this->getEntity();

        $query = $model::find()
            ->orderBy('due_date ASC, description ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model->load($params);

        if (!$model->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'description', $model->description]);

        return $dataProvider;
    }
}
