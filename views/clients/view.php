<?php
/* @var yii\web\View $this  */
/* @var App\Domains\Client\Client $model */
use App\Domains\Client\ClientActions;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->context->controllerDescription, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->context->viewDescription . ': ' . $this->title;
YiiAsset::register($this);
?>
<div class="bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ButtonCreator::build(ClientActions::updateOnView($model)) ?>
        <?= ButtonCreator::build(ClientActions::deleteOnView($model)) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            'cpf:cpf',
            'phone_home:phoneDDD',
            'phone_cell:phoneDDD',
            [
                'attribute' => 'address_street',
                'value' => $model->getFullAddress()
            ],
            [
                'attribute' => 'status',
                'value' => $model->status === 1 ? 'Ativo' : 'Inativo'
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>
</div>