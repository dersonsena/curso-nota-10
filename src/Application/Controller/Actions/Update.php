<?php

namespace App\Application\Controller\Actions;

use Yii;
use App\Infra\ActiveRecord\ActiveRecordAbstract;

trait Update
{
    /**
     * @var string
     */
    public $updateDescription = 'Atualizando Registro';

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->actionDescription = $this->updateDescription;

        /** @var ActiveRecordAbstract $model */
        $model = $this->findModel($id);
        //$model->setScenario('update');

        $post = Yii::$app->getRequest()->post();

        if ($model->load($post) && $model->validate()) {
            return $this->saveFormData();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
