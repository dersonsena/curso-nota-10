<?php
/** @var \App\Domains\Bill\Bill $bill */
use WGenial\NumeroPorExtenso\NumeroPorExtenso;
use yii\helpers\Html;

$numeroExtenso = new NumeroPorExtenso();
$numeroExtenso = $numeroExtenso->converter($bill->amount);
?>
<table>
    <tr>
        <td style="width: 100px">
            <?= Html::img(Yii::getAlias('@webroot/images/logo.jpg'), ['width' => 100]) ?>
        </td>
        <td style="width: 500px; text-align: center">
            <h1 style="font-size: 24pt">RECIBO #<?= $bill->getNumber() ?></h1>
            <h2 style="font-size: 12pt">
                Telefone: (85) 9.8888.2304<br />
                E-mail: lenemmendonca@gmail.com
            </h2>
        </td>
        <td style="width: 170px; text-align: right">
            <h1 style="font-size: 20pt; text-decoration: underline">
                <?= Yii::$app->formatter->asCurrency($bill->amount) ?>
            </h1>
        </td>
    </tr>
</table>

<hr style="margin: 20px 0; border-color: #000">

<p style="margin-bottom: 100px; font-size: 15pt">
    Recebi do Sr(a).
    <span style="font-weight: bold; font-size: 17pt; text-transform: uppercase"><?= $bill->client->name ?></span>
    a importância de
    <span style="font-weight: bold; font-size: 17pt; text-transform: uppercase"><?= $numeroExtenso ?></span>
    referente a
    <span style="font-weight: bold; font-size: 17pt; text-transform: uppercase"><?= $bill->description ?></span>
    para que firmamos o presente recibo para os devidos fins e efeitos legais.
</p>

<table>
    <tr>
        <td style="width: 400px; font-size: 15pt">Fortaleza, <?= date('d/m/Y') ?></td>
        <td style="width: 350px; text-align: center">
            <?= Html::img(Yii::getAlias('@webroot/images/assinatura.png'), ['width' => 240]) ?><br />
            <hr>
            Maria Francilene Medeiros Mendonça
        </td>
    </tr>
</table>