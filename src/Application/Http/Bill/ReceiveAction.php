<?php

namespace App\Application\Http\Bill;

use Yii;
use App\Infra\Repository\Bill\BillRepository;
use yii\base\Action;

class ReceiveAction extends Action
{
    public function run(int $id)
    {
        /** @var BillRepository $repository */
        $repository = $this->controller->getRepository();

        if (!$repository->receive($id)) {
            Yii::$app->getSession()->addFlash('error', 'Houve um erro ao receber conta.');
            return $this->controller->redirect(['index']);
        }

        Yii::$app->getSession()->addFlash('success', 'A conta foi recebida/baixada com sucesso.');
        return $this->controller->redirect(['index']);
    }
}
