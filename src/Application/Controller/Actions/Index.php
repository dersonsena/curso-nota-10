<?php

namespace App\Application\Controller\Actions;

use Yii;
use App\Infra\ActiveRecord\ActiveRecordAbstract;
use App\Infra\Repository\RepositoryAbstract;

trait Index
{
    /**
     * @var string
     */
    public $indexDescription = 'Listagem';

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->actionDescription = $this->indexDescription;

        /** @var ActiveRecordAbstract $searchModel */
        $searchModel = $this->getModelSearch();

        /** @var RepositoryAbstract $repository */
        $repository = $this->getRepository();
        $repository->setEntity($searchModel);

        $dataProvider = $repository->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
