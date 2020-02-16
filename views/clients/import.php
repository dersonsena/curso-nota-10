<?php
/* @var $this yii\web\View */
/* @var $importForm \App\Infra\Forms\Client\Import */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataProvider \yii\data\ArrayDataProvider */
use App\Domains\Client\ClientActions;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $this->context->getActionDescription();
$this->params['breadcrumbs'][] = ['label' => $this->context->getControllerDescription(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="client-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($importForm, 'file')->fileInput([
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= Html::a(
                    '<i class="glyphicon glyphicon-download-alt"></i> Baixar modelo CSV',
                    '@web/files/template-clients.csv',
                    [
                        'title' => 'Baixar arquivo modelo de importação',
                        'target' => '_blank'
                    ])
                ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <?= ButtonCreator::build(ClientActions::importSubmit()) ?>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>