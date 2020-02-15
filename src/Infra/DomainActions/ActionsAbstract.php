<?php

namespace App\Infra\DomainActions;

use App\Infra\ActiveRecord\ActiveRecordAbstract;
use App\Infra\Widgets\ButtonCreator\ButtonCreator;

abstract class ActionsAbstract
{
    /**
     * @return string
     */
    abstract public static function getPath(): string;

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function create(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/create'],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Novo ' . $model::getEntityDescription(true),
            'icon' => 'glyphicon glyphicon-plus-sign',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-primary'
            ])
        ];
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function update(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/update/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Editar',
            'size' => ButtonCreator::SIZE_LITTLE,
            'icon' => 'glyphicon glyphicon-pencil',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-default',
                'title' => 'Atualizar registro',
                'aria-label' => 'Atualizar registro',
                'data-toggle' => 'tooltip',
                'data-pjax' => '0',
            ])
        ];
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function view(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/view/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Ver',
            'size' => ButtonCreator::SIZE_LITTLE,
            'icon' => 'glyphicon glyphicon-eye-open',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-default',
                'title' => 'Ver detalhes do registro',
                'aria-label' => 'Ver detalhes do registro',
                'data-toggle' => 'tooltip',
                'data-pjax' => '0',
            ])
        ];
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function delete(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/delete/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'onlyIcon' => true,
            'size' => ButtonCreator::SIZE_LITTLE,
            'icon' => 'glyphicon glyphicon-trash',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-danger',
                'aria-label' => 'Deletar registro',
                'data-confirm' => 'Deseja realmente remover este registro?',
                'data-toggle' => 'tooltip',
                'data-method' => 'post',
                'data-pjax' => '0',
            ])
        ];
    }
}
