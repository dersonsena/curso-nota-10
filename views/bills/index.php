<?php
/* @var $this yii\web\View */
/* @var $searchModel \App\Domains\Bill\BillSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use App\Domains\Bill\Bill;
use App\Domains\Bill\BillActions;
use App\Infra\GridView\ActionGridColumn;
use App\Infra\GridView\LinkDataColumn;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->context->getControllerDescription();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ButtonCreator::build(BillActions::create($searchModel)) ?>
    </p>

    <div class="bill-search">
        <?= $this->render('_search', ['searchModel' => $searchModel]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'status',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 120px'],
                'contentOptions' => ['class' => 'text-center'],
                'content' => function (Bill $bill) {
                    return $bill->getStatusAsLabel();
                }
            ],
            [
                'attribute' => 'description',
                'class' => LinkDataColumn::class
            ],
            [
                'attribute' => 'client_id',
                'headerOptions' => ['style' => 'width: 180px'],
                'content' => function (Bill $bill) {
                    return $bill->client->name;
                }
            ],
            [
                'attribute' => 'due_date',
                'format' => 'date',
                'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'amount',
                'format' => 'currency',
                'headerOptions' => ['style' => 'width: 130px', 'class' => 'text-right'],
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'class' => ActionGridColumn::class,
                'domainActions' => BillActions::class
            ]
        ],
    ]) ?>
</div>
