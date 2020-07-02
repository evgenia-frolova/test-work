<?php

use yii\db\Migration;

/**
 * Class M200702122300Init
 */
class M200702122300Init extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%test_work_user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'first_name' => $this->string(100)->notNull(),
            'middle_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'last_update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP()'),
        ], $tableOptions);

        $this->createIndex('first_name', '{{%test_work_user}}', 'first_name');
        $this->createIndex('middle_name', '{{%test_work_user}}', 'middle_name');
        $this->createIndex('last_name', '{{%test_work_user}}', 'last_name');

        $this->createTable('{{%test_work_phone}}', [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->bigInteger()->notNull(),
            'phone_number' => $this->string(100)->notNull(),
        ], $tableOptions);

        $this->createIndex('user_id', '{{%test_work_phone}}', 'test_work_phone');

        $this->addForeignKey('fk_test_work_phone', '{{%test_work_phone}}', 'user_id', '{{%test_work_user}}', 'id', 'CASCADE', 'CASCADE');

       $this->insert('{{%test_work_user}}', [
           'first_name' => 'Иван',
           'last_name' => 'Иванов',
           'middle_name' => 'Иванович',
       ]);

        $this->insert('{{%test_work_phone}}', [
            'user_id' => '1',
            'phone_number' => '9201234567',
        ]);

        $this->insert('{{%test_work_phone}}', [
            'user_id' => '1',
            'phone_number' => '9201234568',
        ]);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_test_work_phone', '{{%test_work_phone}}');
        $this->dropTable('{{%test_work_phone}}');
        $this->dropTable('{{%test_work_user}}');
    }
}
