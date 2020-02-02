<?php

use App\Infra\Migration\MigrationAbstract;

/**
 * Class m200202_202924_create_bills
 */
class m200202_202924_create_clients extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTableWith('clients', [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'cpf' => $this->string(11),
            'email' => $this->string(60),
            'phone_home' => $this->string(11),
            'phone_cell' => $this->string(11),
            'phone_commercial' => $this->string(11),
            'address_street' => $this->string(60),
            'address_number' => $this->string(10),
            'address_neighborhood' => $this->string(60),
            'address_zipcode' => $this->char(8),
            'address_complement' => $this->string(60),
            'status' => $this->status(),
            'deleted' => $this->deleted()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
