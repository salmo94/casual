<?php

use yii\db\Migration;

/**
 * Class m230807_160140_create_auth_schema
 */
class m230807_160140_create_auth_schema extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE SCHEMA IF NOT EXISTS auth');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP SCHEMA IF EXISTS auth');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230807_160140_create_auth_schema cannot be reverted.\n";

        return false;
    }
    */
}
