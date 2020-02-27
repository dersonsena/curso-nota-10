<?php

namespace App\Infra\Repository;

use Yii;
use App\Infra\ActiveRecord\ActiveRecordAbstract;

abstract class RepositoryAbstract
{
    /**
     * @var ActiveRecordAbstract
     */
    protected $model;

    /**
     * @return string
     */
    abstract public function getEntityName(): string;

    public function __construct()
    {
        $this->model = Yii::$container->get($this->getEntityName());
    }

    /**
     * @return ActiveRecordAbstract
     */
    public function getEntity(): ActiveRecordAbstract
    {
        return $this->model;
    }

    /**
     * @param ActiveRecordAbstract $entity
     * @return RepositoryAbstract
     */
    public function setEntity(ActiveRecordAbstract $entity)
    {
        $this->model = $entity;
        return $this;
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
     * @param ActiveRecordAbstract $entity
     * @return bool
     */
    public function save(ActiveRecordAbstract $entity)
    {
        return $entity->save();
    }
}
