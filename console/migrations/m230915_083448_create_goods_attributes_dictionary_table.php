<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_attributes_dictionary}}`.
 */
class m230915_083448_create_goods_attributes_dictionary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods_attributes_dictionary}}', [
            'goods_id' => $this->integer()->notNull(),
            'attribute_id' => $this->integer()->notNull(),
            'value_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'PRIMARY KEY(goods_id, attribute_id)',
        ]);


        $this->addForeignKey(
            'fk-goods_attributes_dictionary-goods_id',
            'goods_attributes_dictionary',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_dictionary-attribute_id',
            'goods_attributes_dictionary',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-goods_attributes_dictionary-value_id',
            'goods_attributes_dictionary',
            'value_id',
            'attributes_value',
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
            'fk-goods_attributes_dictionary-goods_id',
            'goods_attributes_dictionary'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_dictionary-attribute_id',
            'goods_attributes_dictionary'
        );

        $this->dropForeignKey(
            'fk-goods_attributes_dictionary-value_id',
            'goods_attributes_dictionary'
        );
        $this->dropTable('{{%goods_attributes_dictionary}}');
    }
}
