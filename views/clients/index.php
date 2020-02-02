<?php
/* @var $this yii\web\View */
/* @var $searchModel \App\Domains\Client\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use App\Infra\GridView\ActionGridColumn;
use App\Infra\GridView\LinkDataColumn;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->context->getControllerDescription();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Novo cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'class' => LinkDataColumn::class
            ],
            [
                'attribute' => 'email',
                'headerOptions' => ['style' => 'width: 350px'],
            ],
            [
                'attribute' => 'cpf',
                'format' => 'cpf',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 190px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            ['class' => ActionGridColumn::class]
        ],
    ]) ?>
</div>
