<?php

use yii\db\Migration;

/**
 * Class m230731_145539_insert_data_into_attribute_types_table
 */
class m230731_145539_insert_data_into_attribute_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%attribute_types}}', ['title'], [
            ['Текстовий'],
            ['Цілочисельний'],
            ['Дробовий'],
            ['Булевий'],
            ['Довідниковий'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230731_145539_insert_data_into_attribute_types_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230731_145539_insert_data_into_attribute_types_table cannot be reverted.\n";

        return false;
    }
    */
}
