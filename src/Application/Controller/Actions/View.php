<?php

namespace App\Application\Controller\Actions;

use yii\web\NotFoundHttpException;

trait View
{
    /**
     * @var string
     */
    public $viewDescription = 'Visualizando';

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->actionDescription = $this->viewDescription;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
}
