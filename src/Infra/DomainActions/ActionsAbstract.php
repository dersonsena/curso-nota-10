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
    public static function updateOnGrid(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/update/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Editar',
            'size' => ButtonCreator::SIZE_LITTLE,
            'icon' => 'glyphicon glyphicon-pencil',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-info',
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
    public static function updateOnView(ActiveRecordAbstract $model, array $options = []): array
    {
        $updateGrid = static::updateOnGrid($model, $options);
        $updateGrid['size'] = ButtonCreator::SIZE_NORMAL;

        return $updateGrid;
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function deleteOnGrid(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/delete/' . $model->id],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Deletar',
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

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function deleteOnView(ActiveRecordAbstract $model, array $options = []): array
    {
        $deleteGrid = static::deleteOnGrid($model, $options);
        $deleteGrid['size'] = ButtonCreator::SIZE_NORMAL;
        $deleteGrid['onlyIcon'] = false;

        return $deleteGrid;
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function back(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath() . '/index'],
            'type' => ButtonCreator::TYPE_LINK,
            'text' => 'Voltar',
            'icon' => 'glyphicon glyphicon-chevron-left',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-default'
            ])
        ];
    }

    /**
     * @param ActiveRecordAbstract $model
     * @param array $options
     * @return array
     */
    public static function save(ActiveRecordAbstract $model, array $options = []): array
    {
        $htmlOptions = ($options['htmlOptions'] ?? []);

        return [
            'to' => [static::getPath()],
            'type' => ButtonCreator::TYPE_SUBMIT,
            'text' => ($model->getIsNewRecord() ? 'Adicionar' : 'Atualizar'),
            'icon' => 'glyphicon glyphicon-floppy-disk',
            'htmlOptions' => array_merge($htmlOptions, [
                'class' => 'btn btn-primary'
            ])
        ];
    }
}
