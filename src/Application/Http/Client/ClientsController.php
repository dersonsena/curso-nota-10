<?php

namespace App\Application\Http\Client;

use App\Domains\Client\Client;
use App\Application\Controller\CRUDController;
use App\Infra\Repository\Client\ClientRepository;

class ClientsController extends CRUDController
{
    public function actions()
    {
        return [
            'import' => ImportAction::class
        ];
    }

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
    public function getRepositoryName(): string
    {
        return ClientRepository::class;
    }
}
