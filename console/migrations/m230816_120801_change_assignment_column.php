<?php

use yii\db\Migration;

/**
 * Class m230816_120801_change_assignment_column
 */
class m230816_120801_change_assignment_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE {{%auth}}.{{%assignment}} ALTER COLUMN user_id TYPE integer USING user_id::integer');

        $this->addForeignKey(
            'fk-assignment-user',
            '{{%auth}}.{{%assignment}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE',
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%auth}}.{{%assignment}}', 'user_id', $this->string());

        // Видаляємо зовнішній ключ
        $this->dropForeignKey('fk-assignment-user', '{{%auth}}.{{%assignment}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_120801_change_assignment_column cannot be reverted.\n";

        return false;
    }
    */
}
