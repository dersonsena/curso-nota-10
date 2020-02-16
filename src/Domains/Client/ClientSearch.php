<?php

namespace App\Domains\Client;

use App\Infra\ActiveRecord\Validators\RemoveSymbolsFilter;

class ClientSearch extends Client
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 60],
            ['cpf', RemoveSymbolsFilter::class]
        ];
    }
}
