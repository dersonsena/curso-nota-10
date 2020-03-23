<?php

namespace App\Application\Controller;

use yii\filters\AccessControl;
use yii\web\Controller;

abstract class ControllerBase extends Controller
{
    /**
     * @var string
     */
    protected $controllerDescription;

    /**
     * @var string
     */
    protected $actionDescription;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getControllerDescription(): string
    {
        return $this->controllerDescription;
    }

    /**
     * @return string
     */
    public function getActionDescription(): string
    {
        return $this->actionDescription;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setActionDescription(string $description)
    {
        $this->actionDescription = $description;
        return $this;
    }
}
