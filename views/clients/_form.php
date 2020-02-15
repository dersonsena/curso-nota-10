<?php
/* @var $this yii\web\View */
/* @var $model \App\Domains\Client\Client */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
?>

<div class="client-form">
    <?php $form = ActiveForm::begin() ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dados Pessoais</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'email') ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'cpf')->widget(MaskedInput::class, [
                            'mask' => '999.999.999-99',
                        ])  ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'phone_home')->widget(MaskedInput::class, [
                            'mask' => ['(99) 9999.9999', '(99) 99999.9999'],
                        ]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'phone_cell')->widget(MaskedInput::class, [
                            'mask' => ['(99) 9999.9999', '(99) 99999.9999'],
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'status')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Endereço</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-5">
                        <?= $form->field($model, 'address_street') ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'address_number') ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'address_neighborhood') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'address_zipcode')->widget(MaskedInput::class, [
                            'mask' => '99999-99',
                        ]) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'address_complement') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
