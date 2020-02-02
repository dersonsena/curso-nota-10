<?php

namespace App\Application\Http\Client;

use Yii;
use App\Application\Controller\CRUDController;
use App\Domains\Client\Client;
use App\Domains\Client\ClientSearch;

class ClientsController extends CRUDController
{
    public $controllerDescription = 'Clientes';

    /*public function actions()
    {
        return array_merge($this->actions(), []);
    }*/

    /**
     * @inheritDoc
     */
    public function getModel()
    {
        return Yii::$container->get(Client::class);
    }

    /**
     * @inheritDoc
     */
    public function getModelSearch()
    {
        return Yii::$container->get(ClientSearch::class);
    }
}
