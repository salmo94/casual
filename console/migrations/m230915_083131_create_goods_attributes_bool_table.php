<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_attributes_bool}}`.
 */
class m230915_083131_create_goods_attributes_bool_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%goods_attributes_bool}}', [
            'goods_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'PRIMARY KEY(goods_id, attribute_id)',
        ]);

        $this->addForeignKey(
            'fk-goods_attributes_bool-goods_id',
            'goods_attributes_bool',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_bool-attribute_id',
            'goods_attributes_bool',
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
            'fk-goods_attributes_bool-goods_id',
            'goods_attributes_bool'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_bool-attribute_id',
            'goods_attributes_bool'
        );

        $this->dropTable('{{%goods_attributes_bool}}');
    }

}
