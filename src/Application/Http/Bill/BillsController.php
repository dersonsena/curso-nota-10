<?php

namespace App\Application\Http\Bill;

use App\Application\Controller\CRUDController;

class BillsController extends CRUDController
{
    public function actions()
    {
        return array_merge($this->actions(), []);
    }
}
