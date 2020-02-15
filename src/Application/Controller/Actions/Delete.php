<?php

namespace App\Application\Controller\Actions;

use Yii;
use App\Infra\ActiveRecord\ActiveRecordAbstract;

trait Delete
{
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        /** @var ActiveRecordAbstract $model */
        $model = $this->findModel($id);

        if (!$model->softDelete()) {
            Yii::$app->getSession()->setFlash('error', $model->getErrorsToHTMLList());
        }

        Yii::$app->getSession()->setFlash('success', 'O registro foi removido com sucesso!');
        return $this->redirect(['index']);
    }
}
