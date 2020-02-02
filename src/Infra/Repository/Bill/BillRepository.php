<?php

namespace App\Infra\Repository\Bill;

use App\Domains\Bill\Bill;
use App\Infra\Repository\RepositoryAbstract;

class BillRepository extends RepositoryAbstract
{
    protected $modelClass = Bill::class;
}
