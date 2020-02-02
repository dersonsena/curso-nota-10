<?php

namespace App\Application\Controller;

use App\Infra\ActiveRecord\ActiveRecordAbstract;
use Exception;
use Yii;
use yii\web\NotFoundHttpException;

abstract class CRUDController extends ControllerBase
{
    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getModel();

    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getModelSearch();

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->actionDescription = 'Listagem';
        $dataProvider = $this->getModelSearch()->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'searchModel' => $this->getModelSearch(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->actionDescription = $this->viewActionDescription;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->actionDescription = $this->createActionDescription;
        $this->model->scenario = $this->createScenario;

        if ($this->model->load($this->getRequest()->post())) {
            if ($this->model->validate()) {
                return $this->saveFormData();
            }
        }

        return $this->render($this->createViewFile, [
            'model' => $this->model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $this->actionDescription = $this->updateActionDescription;
        $this->model = $this->findModel($id);
        $this->model->scenario = $this->updateScenario;

        if ($this->model->load($this->getRequest()->post())) {
            if ($this->model->validate()) {
                return $this->saveFormData();
            }
        }

        return $this->render($this->updateViewFile, [
            'model' => $this->model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        /** @var ModelBase $model */
        $model = $this->findModel($id);
        $model->deleted = Yii::$app->params['active'];
        $model->save(true, ['deleted']);

        $this->getSession()->setFlash('growl', [
            'type' => 'success',
            'title' => 'Tudo certo!',
            'message' => 'O registro foi removido com sucesso!'
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ModelBase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->model->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Metodo que faz o processo de cadastro ou atualizacao de dados
     * @return \yii\web\Response
     */
    protected function saveFormData()
    {
        try {
            if (!$this->model->save() || $this->model->hasErrors()) {
                throw new Exception('Houve um erro ao salvar o registro.' . $this->model->getErrorsToString());
            }

            $this->getSession()->setFlash('growl', [
                'type' => 'success',
                'title' => 'Tudo certo!',
                'message' => 'Seus dados foram gravados com sucesso!'
            ]);

            if (!is_null($this->getRequest()->post('save-and-continue'))) {
                return $this->refresh();
            } else {
                return $this->redirect(['index']);
            }

        } catch(Exception $e) {
            $this->getSession()->setFlash('error', '<strong style="font-size: 1.5em">Opsss... Um erro aconteceu!</strong>' . $e->getMessage());
            return $this->redirect([$this->action->id]);
        }
    }
}
