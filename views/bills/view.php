<?php
/* @var yii\web\View $this  */
/* @var App\Domains\Bill\Bill $model */
use App\Domains\Bill\BillActions;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => $this->context->controllerDescription, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->context->viewDescription . ': ' . $this->title;
YiiAsset::register($this);

?>
<div class="bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= ButtonCreator::build(BillActions::updateOnView($model)) ?>
        <?= ButtonCreator::build(BillActions::deleteOnView($model)) ?>

        <?php if ($model->isReceived()) : ?>
            <?= ButtonCreator::build(BillActions::receiptOnView($model)) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'status',
                'value' => $model->getStatusAsLabel(),
                'format' => 'raw'
            ],
            'id',
            'description',
            'due_date',
            'amount:currency',
            [
                'attribute' => 'client_id',
                'value' => $model->client->name
            ],
            'observations:ntext',
            'created_at:datetime',
            'updated_at',
        ],
    ]) ?>
</div>