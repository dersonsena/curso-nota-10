<?php

namespace App\Domains\Client;

use App\Infra\DomainActions\ActionsAbstract;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;

class ClientActions extends ActionsAbstract
{
    /**
     * @inheritDoc
     */
    public static function getPath(): string
    {
        return '/clients';
    }

    public static function import(Client $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/import'],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Importar ' . $model::getEntityDescription(),
            'icon' => 'glyphicon glyphicon-save-file',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-default'
            ])
        ];
    }
}