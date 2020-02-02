<?php

namespace App\Infra\Migration;

use yii\db\Migration;

class MigrationAbstract extends Migration
{
    use Columns, ValuesGenerators;

    /**
     * The abstraction of the create table process. This routine create the PK index
     * @param string $tableName
     * @param array $specificColumns
     * @param bool $createPK
     */
    public function createTableWith(string $tableName, array $specificColumns, bool $createPK = false)
    {
        $this->createTable(
            "{{%{$tableName}}}",
            array_merge($specificColumns, $this->blameAndTimestampColumns()),
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );

        if ($createPK) {
            $this->addPrimaryKeyColumn($tableName);
        }
    }

    /**
     * Abstract the method of the add the primary key column
     * @param string $tableName
     * @param string $column
     */
    public function addPrimaryKeyColumn(string $tableName, $column = 'id')
    {
        $this->addPrimaryKey("pk_{$tableName}_id", "{{%$tableName}}", $column);
    }
}
