<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_attributes_int}}`.
 */
class m230915_082528_create_goods_attributes_int_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_attributes_int}}', [
            'goods_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'value' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'PRIMARY KEY(goods_id, attribute_id)',
        ]);

        $this->addForeignKey(
            'fk-goods_attributes_int-goods_id',
            'goods_attributes_int',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_int-attribute_id',
            'goods_attributes_int',
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
            'fk-goods_attributes_int-goods_id',
            'goods_attributes_int'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_int-attribute_id',
            'goods_attributes_int'
        );
        $this->dropTable('{{%goods_attributes_int}}');
    }
}
