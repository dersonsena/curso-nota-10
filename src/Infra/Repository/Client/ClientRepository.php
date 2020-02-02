<?php

namespace App\Infra\Repository\Client;

use App\Domains\Client\Client;
use App\Infra\Repository\RepositoryAbstract;

class ClientRepository extends RepositoryAbstract
{
    protected $modelClass = Client::class;
}
