<?php

namespace App\Application\Http\Bill;

use Yii;
use App\Domains\Bill\Bill;
use kartik\mpdf\Pdf;
use App\Infra\Repository\Bill\BillRepository;
use yii\base\Action;
use yii\web\Response;

class ReceiptAction extends Action
{
    public function run(int $id)
    {
        Yii::$app->response->format = Response::FORMAT_RAW;

        /** @var BillRepository $repository */
        $repository = $this->controller->getRepository();

        /** @var Bill $bill */
        $bill = $repository->findOne($id);

        /** @var Pdf $pdfComponent */
        $pdfComponent = Yii::$app->pdf;
        $pdfComponent->format = [210, 148]; // A5
        $pdfComponent->marginTop = 10;
        $pdfComponent->marginLeft = 10;
        $pdfComponent->marginRight = 10;
        $pdfComponent->marginBottom = 10;
        $pdfComponent->methods = [
            'SetTitle' => "Recibo Nº {$bill->getNumber()} - {$bill->description}"
        ];

        $pdfComponent->content = $this->controller->renderPartial('_receipt-pdf', [
            'bill' => $bill
        ]);

        return $pdfComponent->render();
    }
}
