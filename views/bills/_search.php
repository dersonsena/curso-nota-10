<?php
/* @var $searchModel \App\Domains\Bill\BillSearch */

use App\Domains\Bill\Bill;
use App\Domains\Client\Client;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-search"></i> Filtros para Pesquisa
            </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($searchModel, 'dueDateStart')->widget(DatePicker::class, [
                        'language' => 'pt',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                        ]
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($searchModel, 'dueDateEnd')->widget(DatePicker::class, [
                        'language' => 'pt',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd/mm/yyyy',
                        ]
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'client_id')->dropDownList(Client::dropdownOptions('name'), [
                        'prompt' => ':: TODOS ::'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($searchModel, 'status')->dropDownList(Bill::getStatusList(), [
                        'prompt' => ':: TODOS ::'
                    ]) ?>
                </div>
                <div class="col-md-2" style="margin-top: 24px">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> Pesquisar', [
                        'class' => 'btn btn-primary btn-block'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>

