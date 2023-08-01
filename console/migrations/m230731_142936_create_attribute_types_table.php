<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attribute_types}}`.
 */
class m230731_142936_create_attribute_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attribute_types}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%attribute_types}}');
    }
}
