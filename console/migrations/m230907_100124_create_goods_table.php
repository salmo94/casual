<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods}}`.
 */
class m230907_100124_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goods}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'price' => $this->float(),
            'article' => $this->string(25),
            'available' => $this->smallInteger()->defaultValue(1),
            'category_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'fk-goods-category_id',
            'goods',
            'category_id',
            'categories',
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
        $this->dropForeignKey('fk-goods-category_id','goods');
        $this->dropTable('{{%goods}}');
    }
}
