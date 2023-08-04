<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_value}}`.
 */
class m230803_185322_create_attributes_value_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_value}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'attribute_id' => $this->integer()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp()
        ]);
        $this->addForeignKey(
            'fk-attributes_value-attributes',
            'attributes_value',
            'attribute_id',
            'attributes',
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
        $this->dropForeignKey('fk-attributes_value-attributes', 'attributes_value');
        $this->dropTable('{{%attributes_value}}');
    }
}
