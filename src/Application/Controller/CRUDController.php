<?php

namespace App\Application\Controller;

use Yii;
use Exception;
use App\Application\Controller\Actions\Create;
use App\Application\Controller\Actions\Delete;
use App\Application\Controller\Actions\Index;
use App\Application\Controller\Actions\Update;
use App\Application\Controller\Actions\View;
use App\Infra\ActiveRecord\ActiveRecordAbstract;
use yii\web\NotFoundHttpException;

abstract class CRUDController extends ControllerBase
{
    use Index, View, Create, Update, Delete;

    /**
     * @var ActiveRecordAbstract
     */
    private $model;

    /**
     * @var ActiveRecordAbstract
     */
    private $modelSearch;

    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getModelName(): string;

    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getModelSearchName(): string;

    public function init()
    {
        parent::init();

        $this->model = Yii::$container->get($this->getModelName());
        $this->modelSearch = Yii::$container->get($this->getModelSearchName());

        $this->controllerDescription = $this->model::getEntityDescription();
    }

    /**
     * @return ActiveRecordAbstract
     */
    protected function getModel(): ActiveRecordAbstract
    {
        return $this->model;
    }

    /**
     * @return ActiveRecordAbstract
     */
    protected function getModelSearch(): ActiveRecordAbstract
    {
        return $this->modelSearch;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActiveRecordAbstract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->model = $this->model::findOne($id);

        if (is_null($this->model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->model;
    }

    /**
     * Metodo que faz o processo de cadastro ou atualizacao de dados
     * @return \yii\web\Response
     */
    protected function saveFormData()
    {
        try {
            $isNewRecord = $this->getModel()->getIsNewRecord();

            if (!$this->getModel()->save() || $this->getModel()->hasErrors()) {
                throw new Exception('Houve um erro ao salvar o registro.' . $this->getModel()->getErrorsToHTMLList());
            }

            Yii::$app->getSession()->setFlash('success', 'Seus dados foram gravados com sucesso!');

            if ($isNewRecord) {
                return $this->redirect(['index']);
            }

            return $this->redirect(['update', 'id' => $this->getModel()->id]);

        } catch (Exception $e) {
            Yii::$app->getSession()->setFlash('error', $e->getMessage());
            return $this->redirect([$this->action->id]);
        }
    }
}
