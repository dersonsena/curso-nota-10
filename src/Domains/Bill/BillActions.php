<?php

namespace App\Domains\Bill;

use App\Infra\DomainActions\ActionsAbstract;

class BillActions extends ActionsAbstract
{
    /**
     * @inheritDoc
     */
    public static function getPath(): string
    {
        return '/bills';
    }
}
