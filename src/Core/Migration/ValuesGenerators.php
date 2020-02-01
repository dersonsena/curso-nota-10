<?php

namespace App\Core\Migration;

use DateTime;

trait ValuesGenerators
{
    /**
     * Generate the timestamp from current date and time
     * @return string
     * @throws \Exception
     */
    public function nowValue(): string
    {
        return (new DateTime())->format('Y-m-d H:i:s');
    }
}
