<?php

use App\Infra\Migration\MigrationAbstract;

/**
 * Class m200227_215008_add_bills_parcel_number_column
 */
class m200227_215008_add_bills_parcel_number_column extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bills}}', 'parcel_number', $this->smallInteger()->defaultValue(null)->after('amount'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bills}}', 'parcel_number');
    }
}
