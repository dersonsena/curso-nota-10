<?php

use App\Infra\Migration\MigrationAbstract;

/**
 * Class m200222_224517_add_bills_bill_id_column_and_fk
 */
class m200222_224517_add_bills_bill_id_column_and_fk extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bills}}', 'bill_parent_id', $this->integer()->defaultValue(null)->after('client_id'));
        $this->addForeignKey('fk_bills_bill_parent_id', '{{%bills}}', 'bill_parent_id', '{{%bills}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bills}}', 'bill_parent_id');
        $this->dropForeignKey('fk_bills_bill_parent_id', '{{%bills}}');
    }
}
