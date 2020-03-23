<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Dashboard</h1>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-usd"></i> Últimos Lançamentos
            </div>
            <div class="panel-body">
                ...
            </div>
            <div class="panel-footer">
                <?= Html::a('Ver todos', null, [
                    'title' => 'Ver todos os lançamentos do Contas a Receber'
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-exclamation-sign"></i> Lançamentos em Atraso
            </div>
            <div class="panel-body">
                ...
            </div>
            <div class="panel-footer">
                <?= Html::a('Ver todos', null, [
                    'title' => 'Ver todos os lançamentos em Atraso'
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-certificate"></i> Lançamentos em Aberto
            </div>
            <div class="panel-body">
                ...
            </div>
            <div class="panel-footer">
                <?= Html::a('Ver todos', null, [
                    'title' => 'Ver todos os lançamentos em Aberto'
                ]) ?>
            </div>
        </div>
    </div>
</div>