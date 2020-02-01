<?php

namespace App\Core\Migration;

use yii\db\ColumnSchemaBuilder;
use yii\db\Expression;

trait Columns
{
    /**
     * Setup the binary id column
     * @param int $length
     * @param bool $notNull
     * @return string
     */
    public function binaryColumn(int $length = 16, bool $notNull = true): string
    {
        $notNullStatement = ($notNull ? 'NOT NULL' : '');
        return "BINARY({$length}) {$notNullStatement} COMMENT '(DC2Type:uuid_binary_ordered_time)'";
    }

    /**
     * Setup the UUID column
     * @return ColumnSchemaBuilder
     */
    public function uuid()
    {
        return $this->string(36)->notNull()->unique()->comment('(DC2Type:uuid)');
    }

    /**
     * Setup the enum column
     * @param array $types
     * @param bool $notNull
     * @return string
     */
    public function enum(array $types, bool $notNull = true)
    {
        $notNullStatement = ($notNull ? 'NOT NULL' : '');
        $parse = "'" . implode("', '", $types) . "'";
        return "ENUM ({$parse}) {$notNullStatement}";
    }

    /**
     * Setup the status column
     * @return ColumnSchemaBuilder
     */
    public function status()
    {
        return $this->smallInteger(1)->notNull()->defaultValue(1);
    }

    /**
     * Setup the deleted column
     * @return ColumnSchemaBuilder
     */
    public function deleted()
    {
        return $this->smallInteger(1)->notNull()->defaultValue(0);
    }

    /**
     * Returns the blame and timed events columns list
     * @return array
     */
    public function blameAndTimestampColumns(): array
    {
        return array_merge(
            $this->timestampColumns(),
            $this->blameColumns()
        );
    }

    /**
     * Returns the blame columns list
     * @return array
     */
    public function blameColumns(): array
    {
        return [
            'created_by' => $this->string(100)->defaultValue(new Expression('NULL')),
            'updated_by' => $this->string(100)->defaultValue(new Expression('NULL')),
            'deleted_by' => $this->string(100)->defaultValue(new Expression('NULL')),
        ];
    }

    /**
     * Returns the timed events columns list
     * @return array
     */
    public function timestampColumns(): array
    {
        return [
            'created_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
            'updated_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
            'deleted_at' => $this->dateTime()->defaultValue(new Expression('NULL')),
        ];
    }

    /**
     * Returns the array with the address columns
     * @param bool $required
     * @return array
     */
    public function addressColumns(bool $required = true)
    {
        $street = $this->string(100);
        $number = $this->string(10);
        $neighborhood = $this->string(100);
        $zip = $this->string(8);

        if ($required) {
            $street->notNull();
            $number->notNull();
            $neighborhood->notNull();
            $zip->notNull();
        }

        return [
            'address_street' => $street,
            'address_number' => $number,
            'address_neighborhood' => $neighborhood,
            'address_zip' => $zip,
            'address_complement' => $this->string(100),
        ];
    }
}
