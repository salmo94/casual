<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goods_images}}`.
 */
class m230920_131544_create_goods_images_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%goods_images}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->notNull(),
            'image_path' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp(),
        ]);

        $this->addForeignKey(
            'fk-goods_images-goods_id',
            'goods_images',
            'goods_id',
            'goods',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-goods_images-goods_id','goods_images');
        $this->dropTable('{{%goods_images}}');
    }
}
