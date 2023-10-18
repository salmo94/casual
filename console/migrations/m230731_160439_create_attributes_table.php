<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes}}`.
 */
class m230731_160439_create_attributes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'type_id' => $this->smallInteger()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp()
        ]);
        $this->addForeignKey(
            'fk-attribute-category_id',
            'attributes',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-attribute-category_id', 'attributes');
        $this->dropTable('{{%attributes}}');
    }
}
