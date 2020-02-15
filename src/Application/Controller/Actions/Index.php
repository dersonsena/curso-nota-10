<?php

namespace App\Application\Controller\Actions;

use Yii;

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
        $dataProvider = $this->getModelSearch()->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'searchModel' => $this->getModelSearch(),
            'dataProvider' => $dataProvider,
        ]);
    }
}
