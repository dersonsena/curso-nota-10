<?php

namespace App\Application\Controller\Actions;

use Exception;
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
            try {
                $this->saveFormData();

                Yii::$app->getSession()->setFlash('success', 'Seus dados atualizados com sucesso!');
                return $this->redirect(['update', 'id' => $model->id]);
            } catch (Exception $e) {
                Yii::$app->getSession()->setFlash('error', $e->getMessage());
                return $this->redirect([$this->action->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
