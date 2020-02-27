<?php

use App\Infra\Migration\MigrationAbstract;

/**
 * Class m200202_204109_create_bills
 */
class m200202_204109_create_bills extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWith('bills', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'type' => $this->enum([1, 2])->notNull()->defaultValue(1),
            'status' => $this->enum([1, 2, 3])->notNull()->defaultValue(1),
            'description' => $this->string(60)->notNull(),
            'due_date' => $this->date()->notNull(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'observations' => $this->text(),
            'payment_date' => $this->dateTime(),
            'payment_user' => $this->string(100),
            'cancellation_date' => $this->dateTime(),
            'cancellation_reason' => $this->text(),
            'cancellation_user' => $this->string(100),
        ]);

        $this->addForeignKey('fk_bills_client', '{{%bills}}', 'client_id', '{{%clients}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_bills_client', '{{%bills}}');
        $this->dropTable('{{%bills}}');
    }
}
