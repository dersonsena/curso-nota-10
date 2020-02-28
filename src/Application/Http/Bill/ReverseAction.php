<?php

namespace App\Application\Http\Bill;

use Yii;
use App\Infra\Repository\Bill\BillRepository;
use yii\base\Action;

class ReverseAction extends Action
{
    public function run(int $id)
    {
        /** @var BillRepository $repository */
        $repository = $this->controller->getRepository();

        if (!$repository->reverse($id)) {
            Yii::$app->getSession()->addFlash('error', 'Houve um erro ao estornar conta.');
            return $this->controller->redirect(['index']);
        }

        Yii::$app->getSession()->addFlash('success', 'A conta foi estornada com sucesso. Ela agora está como aberta.');
        return $this->controller->redirect(['index']);
    }
}
