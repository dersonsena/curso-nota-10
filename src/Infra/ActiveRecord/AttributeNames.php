<?php

namespace App\Infra\ActiveRecord;

trait AttributeNames
{
    /**
     * @var string
     */
    private $statusAttribute = 'status';

    /**
     * @var string
     */
    private $deletedAttribute = 'deleted';

    /**
     * @var string
     */
    private $createdAtAttribute = 'created_at';

    /**
     * @var string
     */
    private $updatedAtAttribute = 'updated_at';

    /**
     * @var string
     */
    private $deletedAtAttribute = 'deleted_at';

    /**
     * @var string
     */
    private $createdByAttribute = 'created_by';

    /**
     * @var string
     */
    private $updatedByAttribute = 'updated_by';

    /**
     * @var string
     */
    private $deletedByAttribute = 'deleted_by';

    /**
     * @return bool|string
     */
    private function getCreatedAtAttribute()
    {
        return (array_key_exists($this->createdAtAttribute, $this->attributes) ? $this->createdAtAttribute : false);
    }

    /**
     * @return bool|string
     */
    private function getUpdatedAtAttribute()
    {
        return (array_key_exists($this->updatedAtAttribute, $this->attributes) ? $this->updatedAtAttribute : false);
    }

    /**
     * @return bool|string
     */
    private function getDeletedAtAttribute()
    {
        return (array_key_exists($this->deletedAtAttribute, $this->attributes) ? $this->deletedAtAttribute : false);
    }

    /**
     * @return bool|string
     */
    private function getCreatedByAttribute()
    {
        return (array_key_exists($this->createdByAttribute, $this->attributes) ? $this->createdByAttribute : false);
    }

    /**
     * @return bool|string
     */
    private function getUpdatedByAttribute()
    {
        return (array_key_exists($this->updatedByAttribute, $this->attributes) ? $this->updatedByAttribute : false);
    }

    /**
     * @return bool|string
     */
    private function getDeletedByAttribute()
    {
        return (array_key_exists($this->deletedByAttribute, $this->attributes) ? $this->deletedByAttribute : false);
    }
}
