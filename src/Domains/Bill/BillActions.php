<?php

namespace App\Domains\Bill;

use App\Infra\ActiveRecord\ActiveRecordAbstract;
use App\Infra\DomainActions\ActionsAbstract;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;

class BillActions extends ActionsAbstract
{
    /**
     * @inheritDoc
     */
    public static function getPath(): string
    {
        return '/bills';
    }

    /**
     * @inheritDoc
     */
    public static function updateOnGrid(ActiveRecordAbstract $model, array $options = []): array
    {
        $options = parent::updateOnGrid($model, $options);
        $options['text'] = '';
        $options['htmlOptions']['title'] = 'Atualizar ' . $model::getEntityDescription(true);

        return $options;
    }

    /**
     * @param Bill $model
     * @param array $options
     * @return array
     */
    public static function receive(Bill $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/receive/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Receber',
            'icon' => 'glyphicon glyphicon-thumbs-up',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-success btn-sm',
                'title' => 'Receber esta ' . $model::getEntityDescription(true),
                'data-confirm' => 'Deseja realmente receber essa conta?',
                'data-method' => 'post',
                'data-pjax' => '0'
            ])
        ];
    }

    public static function reverse(Bill $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/reverse/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Estornar',
            'icon' => 'glyphicon glyphicon-remove-circle',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-default btn-sm',
                'title' => 'Estornar esta ' . $model::getEntityDescription(true),
                'data-confirm' => 'Deseja realmente fazer o estorno dessa conta?',
                'data-method' => 'post',
                'data-pjax' => '0'
            ])
        ];
    }
}
