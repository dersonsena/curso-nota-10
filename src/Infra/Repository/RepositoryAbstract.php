<?php

namespace App\Infra\Repository;

use App\Application\ActiveRecord\ActiveRecordAbstract;
use yii\db\Exception;

abstract class RepositoryAbstract
{
    /**
     * @var string
     */
    protected $modelClass;

    /**
     * @var ActiveRecordAbstract
     */
    protected $model;

    public function __construct()
    {
        if (empty($this->modelClass)) {
            throw new Exception('The "$modelClass" attribute is required.');
        }

        $this->model = new $this->modelClass;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function find()
    {
        return $this->model::find();
    }

    /**
     * @param $condition
     * @return ActiveRecordAbstract|null
     */
    public function findOne($condition)
    {
        return $this->model::findOne($condition);
    }

    /**
     * @return ActiveRecordAbstract
     */
    public function getEntity(): ActiveRecordAbstract
    {
        return $this->model;
    }
}
