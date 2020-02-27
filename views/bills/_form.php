<?php
/* @var $this yii\web\View */
/* @var $model Bill */
/* @var $form yii\widgets\ActiveForm */

use App\Domains\Bill\Bill;
use App\Domains\Bill\BillActions;
use App\Domains\Client\Client;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;
use dosamigos\datepicker\DatePicker;
use kartik\money\MaskMoney;
use yii\widgets\ActiveForm;
?>

<div class="client-form">
    <?php $form = ActiveForm::begin() ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Dados da Conta</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'description')->textInput([
                        'autofocus' => true
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'client_id')->dropDownList(Client::dropdownOptions('name'), [
                        'prompt' => ':: SELECIONE ::'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'amount')->widget(MaskMoney::class, [
                        'pluginOptions' => [
                            'prefix' => 'R$ ',
                            'allowNegative' => false
                        ]
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'due_date')->widget(DatePicker::class, [
                        'language' => 'pt',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                        ]
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'status')->dropDownList(Bill::getStatusList([Bill::STATUS_CANCELLED]), [
                        'prompt' => ':: SELECIONE ::'
                    ]) ?>
                </div>
            </div>

            <?php if ($model->getIsNewRecord()) : ?>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'hasRegistration')->checkbox() ?>
                        <?= $form->field($model, 'registrationAmount')
                            ->label(false)
                            ->widget(MaskMoney::class, [
                                'options' => [
                                    //'disabled' => true
                                ],
                                'pluginOptions' => [
                                    'prefix' => 'R$ ',
                                    'allowNegative' => false
                                ]
                            ]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'generateBills')->checkbox() ?>
                        <?= $form->field($model, 'numberOfBills')
                            ->label(false)
                            ->widget(MaskMoney::class, [
                                'options' => [
                                    'placeholder' => 'Quantos meses?',
                                    'maxlength' => 2,
                                    //'disabled' => true
                                ],
                                'pluginOptions' => [
                                    'prefix' => '',
                                    'allowNegative' => false,
                                    'allowZero' => false,
                                    'precision' => 0
                                ]
                            ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 hint-block">
                        <p><strong><i class="glyphicon glyphicon-info-sign"></i> Receber Matrícula: </strong> se marcado, será criado um lançamento baseado nesta conta, no formato: {DESCRIÇÃO} [Matrícula]</p>
                        <p><strong><i class="glyphicon glyphicon-info-sign"></i> Gerar contas futuras: </strong> se marcado, serão criadas contas futuras com o valor informado com a data de vencimento baseado nesta conta.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Observações desta Conta</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'observations')
                        ->textarea(['rows' => 7])
                        ->label(false) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= ButtonCreator::build(BillActions::back($model)) ?>
        <?= ButtonCreator::build(BillActions::save($model)) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
