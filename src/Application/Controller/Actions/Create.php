<?php

namespace App\Application\Controller\Actions;

use App\Infra\ActiveRecord\ActiveRecordAbstract;
use Yii;

trait Create
{
    /**
     * @var string
     */
    public $createDescription = 'Novo Registro';

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->actionDescription = $this->createDescription;

        /** @var ActiveRecordAbstract $model */
        $model = $this->getModel();
        //$model->setScenario('create');

        $post = Yii::$app->getRequest()->post();

        if ($model->load($post) && $model->validate()) {
            return $this->saveFormData();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
