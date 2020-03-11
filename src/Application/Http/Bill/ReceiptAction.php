<?php

namespace App\Application\Http\Bill;

use Yii;
use App\Infra\Repository\Bill\BillRepository;
use yii\base\Action;

class ReceiptAction extends Action
{
    public function run(int $id)
    {
        /** @var BillRepository $repository */
        $repository = $this->controller->getRepository();

        return 'oi';
    }
}
