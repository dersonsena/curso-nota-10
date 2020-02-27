<?php

namespace App\Infra\Repository\Bill;

use App\Domains\Bill\Bill;
use App\Domains\Bill\BillSearch;
use App\Infra\Repository\RepositoryAbstract;
use Yii;
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
        /** @var BillSearch $model */
        $model = $this->getEntity();

        $query = $model::find()
            ->orderBy('status ASC, due_date ASC, description ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model->load($params);

        if (!$model->validate()) {
            return $dataProvider;
        }

        $dueDateStart = Yii::$app->getFormatter()->asDateUS($model->dueDateStart);
        $dueDateEnd = Yii::$app->getFormatter()->asDateUS($model->dueDateEnd);

        $query->andFilterWhere([
            'client_id' => $model->client_id,
            'status' => $model->status,
        ]);

        $query->andFilterWhere(['between', 'due_date', $dueDateStart, $dueDateEnd]);
        $query->andFilterWhere(['like', 'description', $model->description]);

        return $dataProvider;
    }
}
