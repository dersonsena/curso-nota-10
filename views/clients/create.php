<?php
/* @var $this yii\web\View */
/* @var $model \App\Domains\Client\Client */
use yii\helpers\Html;

$this->title = $this->context->getActionDescription();
$this->params['breadcrumbs'][] = ['label' => $this->context->getControllerDescription(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
