<?php

use yii\db\Migration;

/**
 * Class m230725_140303_create_unique_index_to_title_categories
 */
class m230725_140303_create_unique_index_to_title_categories extends Migration
{
    private const TABLE = 'categories';
    private const INDEX = 'unique_title_idx';

    public function safeUp()
    {
        $this->createIndex(self::INDEX, self::TABLE, 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(self::INDEX, self::TABLE);
    }
}
