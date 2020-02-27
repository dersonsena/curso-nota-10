<?php

namespace App\Infra\GridView;

use App\Domains\Client\ClientActions;
use App\Infra\DomainActions\ActionsAbstract;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\User;

class ActionGridColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    public $header = 'Ações';

    /**
     * @inheritdoc
     */
    public $headerOptions = ['style' => 'width: 215px', 'class'=>'text-center'];

    /**
     * @inheritdoc
     */
    public $contentOptions = ['class' => 'text-center'];

    /**
     * @var ActionsAbstract
     */
    public $domainActions;

    /**
     * @var User
     */
    private $user;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->template = '<div class="btn-group" role="group">'. $this->template .'</div>';
        $this->user = Yii::$app->user;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->createViewButton();
        }

        if (!isset($this->buttons['update'])) {
            $this->createUpdateButton();
        }

        if (!isset($this->buttons['delete'])) {
            $this->createDeleteButton();
        }
    }

    /**
     * Metodo que cria o botao view nas acoes, caso ele nao exista
     * @return string
     */
    private function createViewButton()
    {
        $this->buttons['view'] = function ($url, $model, $key) {
            $options = array_merge($this->domainActions::view($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }

    /**
     * Metodo que cria o botao update nas acoes, caso ele nao exista
     * @return string
     */
    private function createUpdateButton()
    {
        $this->buttons['update'] = function ($url, $model, $key) {
            $options = array_merge($this->domainActions::updateOnGrid($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }

    /**
     * Metodo que cria o botao delete nas acoes, caso ele nao exista
     * @return string
     */
    private function createDeleteButton()
    {
        $this->buttons['delete'] = function ($url, $model, $key) {
            $options = array_merge($this->domainActions::deleteOnGrid($model), $this->buttonOptions);
            return ButtonCreator::build($options);
        };
    }
}