<?php

namespace App\Application\Http\Bill;

use App\Application\Controller\CRUDController;
use App\Domains\Bill\Bill;
use App\Infra\Repository\Bill\BillRepository;

class BillsController extends CRUDController
{
    /**
     * @inheritDoc
     */
    public function getModelName(): string
    {
        return Bill::class;
    }

    /**
     * @inheritDoc
     */
    public function getRepositoryName(): string
    {
        return BillRepository::class;
    }

    public function actions()
    {
        return [
            'create' => CreateAction::class,
            'receive' => ReceiveAction::class,
            'reverse' => ReverseAction::class
        ];
    }
}
