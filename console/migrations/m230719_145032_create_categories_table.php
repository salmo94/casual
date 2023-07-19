<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m230719_145032_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey()->notNull(),
            'title' => $this->string(),
            'status' => $this->smallInteger(),
            'is_available' => $this->boolean(),
            'is_deleted' => $this->smallInteger(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
