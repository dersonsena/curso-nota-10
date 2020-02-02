<?php

use App\Infra\Migration\MigrationAbstract;
use yii\base\Security;
use yii\db\Expression;

/**
 * Class m200202_140810_create_users
 */
class m200202_140810_create_users extends MigrationAbstract
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = [
            'id' => $this->primaryKey(),
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(60)->notNull(),
            'password' => $this->string(60)->notNull(),
            'auth_key' => $this->text(),
            'reset_token' => $this->string(100)->defaultValue(null),
            'status' => $this->status(),
            'deleted' => $this->deleted()
        ];

        $this->createTableWith('users', $columns);

        /** @var Security $security */
        $security = Yii::$app->getSecurity();
        $password = $security->generatePasswordHash('123456');

        $this->batchInsert(
            '{{%users}}',
            ['name', 'email', 'password', 'auth_key', 'created_at', 'created_by'],
            [
                [
                    'Administrador',
                    'admin@cursonota10.com.br',
                    $password,
                    $security->generateRandomString(),
                    new Expression('NOW()'),
                    'migration'
                ],
                [
                    'Dayanny Maria',
                    'dayannymaria@gmail.com',
                    $password,
                    $security->generateRandomString(),
                    new Expression('NOW()'),
                    'migration'
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}