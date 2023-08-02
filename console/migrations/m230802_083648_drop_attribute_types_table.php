<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%attribute_types}}`.
 */
class m230802_083648_drop_attribute_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%attribute_types}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%attribute_types}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
