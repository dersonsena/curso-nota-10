<?php

namespace App\Infra\Repository\Bill;

use Yii;
use App\Domains\Bill\Bill;
use App\Domains\Bill\BillSearch;
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
        /** @var BillSearch $model */
        $model = $this->getEntity();
        $model->status = '';

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

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function receive(int $id): bool
    {
        /** @var Bill $bill */
        $bill = $this->findOne($id);

        if (!$bill) {
            return false;
        }

        $identity = Yii::$app->getUser()->getIdentity();

        $bill->status = (string)Bill::STATUS_RECEIVED;
        $bill->payment_date = date('d/m/Y H:i');
        $bill->payment_user = $identity->name . " [{$identity->getId()}]";

        return $bill->save();
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function reverse(int $id): bool
    {
        /** @var Bill $bill */
        $bill = $this->findOne($id);

        if (!$bill) {
            return false;
        }

        $bill->status = (string)Bill::STATUS_OPEN;
        $bill->payment_date = null;
        $bill->payment_user = null;

        return $bill->save();
    }
}
