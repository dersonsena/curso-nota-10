<?php

namespace App\Application\Controller;

use Yii;
use Exception;
use App\Infra\Repository\RepositoryAbstract;
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
     * @var RepositoryAbstract
     */
    private $repository;

    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getModelName(): string;

    /**
     * @return ActiveRecordAbstract
     */
    abstract public function getRepositoryName(): string;

    public function init()
    {
        parent::init();

        $this->model = Yii::$container->get($this->getModelName());
        $this->repository = Yii::$container->get($this->getRepositoryName());

        if (class_exists($this->getModelName() . 'Search')) {
            $this->modelSearch = Yii::$container->get($this->getModelName() . 'Search');
        }

        $this->controllerDescription = $this->model::getEntityDescription();
    }

    /**
     * @return ActiveRecordAbstract
     */
    public function getModel(): ActiveRecordAbstract
    {
        return $this->model;
    }

    /**
     * @param ActiveRecordAbstract $model
     * @return $this
     */
    public function setModel(ActiveRecordAbstract $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return ActiveRecordAbstract
     */
    protected function getModelSearch(): ActiveRecordAbstract
    {
        return $this->modelSearch;
    }

    /**
     * @return RepositoryAbstract
     */
    public function getRepository(): RepositoryAbstract
    {
        return $this->repository;
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
        $this->model = $this->repository->findOne($id);

        if (is_null($this->model)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->model;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function saveFormData(): bool
    {
        if (!$this->getRepository()->save($this->getModel()) || $this->getModel()->hasErrors()) {
            throw new Exception('Houve um erro ao salvar o registro.' . $this->getModel()->getErrorsToHTMLList());
        }

        return true;
    }
}
