<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_attributes_text}}`.
 */
class m230915_080525_create_goods_attributes_text_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_attributes_text}}', [
            'goods_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'value' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'PRIMARY KEY(goods_id, attribute_id)',
        ]);

        $this->addForeignKey(
            'fk-goods_attributes_text-goods_id',
            'goods_attributes_text',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_text-attribute_id',
            'goods_attributes_text',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-goods_attributes_text-goods_id',
            'goods_attributes_text'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_text-attribute_id',
            'goods_attributes_text'
        );
        $this->dropTable('{{%goods_attributes_text}}');
    }
}
