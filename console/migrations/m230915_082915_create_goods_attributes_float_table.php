<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_attributes_float}}`.
 */
class m230915_082915_create_goods_attributes_float_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_attributes_float}}', [
            'goods_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'value' => $this->float()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'PRIMARY KEY(goods_id, attribute_id)',
        ]);

        $this->addForeignKey(
            'fk-goods_attributes_float-goods_id',
            'goods_attributes_float',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_float-attribute_id',
            'goods_attributes_float',
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
            'fk-goods_attributes_float-goods_id',
            'goods_attributes_float'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_float-attribute_id',
            'goods_attributes_float'
        );
        $this->dropTable('{{%goods_attributes_float}}');
    }
}
