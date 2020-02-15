<?php

namespace App\Infra\ActiveRecord\Validators;

use yii\validators\FilterValidator;

class RemoveSymbolsFilter extends FilterValidator
{
    public function init()
    {
        $this->filter = function ($value) {
            return preg_replace("/[^a-zA-Z0-9]/", "", $value);
        };

        parent::init();
    }
}