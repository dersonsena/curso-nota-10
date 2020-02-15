<?php

namespace App\Application\Http\Client;

use App\Application\Controller\CRUDController;
use App\Domains\Client\Client;
use App\Domains\Client\ClientSearch;

class ClientsController extends CRUDController
{
    /**
     * @inheritDoc
     */
    public function getModelName(): string
    {
        return Client::class;
    }

    /**
     * @inheritDoc
     */
    public function getModelSearchName(): string
    {
        return ClientSearch::class;
    }
}
