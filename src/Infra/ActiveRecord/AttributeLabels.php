<?php

namespace App\Infra\ActiveRecord;

trait AttributeLabels
{
    /**
     * @var string
     */
    protected $idLabel = 'ID';

    /**
     * @var string
     */
    protected $createdAtLabel = 'Data de Criação';

    /**
     * @var string
     */
    protected $updateAtLabel = 'Última Atualização';

    /**
     * @var string
     */
    protected $deletedAtLabel = 'Data de Remoção';

    /**
     * @var string
     */
    protected $createdByLabel = 'Criado por';

    /**
     * @var string
     */
    protected $updatedByLabel = 'Última Atualização por';

    /**
     * @var string
     */
    protected $deletedByLabel = 'Deletado por';

    /**
     * @var string
     */
    protected $statusLabel = 'Registro Ativo';

    /**
     * @param array $specificAttributes
     * @return array
     */
    protected function buildAttributeLabels(array $specificAttributes): array
    {
        return array_merge(
            ['id' => $this->idLabel],
            $specificAttributes,
            [
                'status' => $this->statusLabel,
                'created_at' => $this->createdAtLabel,
                'updated_at' => $this->updateAtLabel,
                'deleted_at' => $this->deletedAtLabel,
                'created_by' => $this->createdByLabel,
                'updated_by' => $this->updatedByLabel,
                'deleted_by' => $this->deletedByLabel,
            ]
        );
    }
}
