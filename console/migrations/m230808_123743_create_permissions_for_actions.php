<?php

use yii\db\Migration;

/**
 * Class m230808_123743_create_permissions_for_actions
 */
class m230808_123743_create_permissions_for_actions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $indexCategory = $auth->createPermission('indexCategory');
        $indexCategory->description = 'Index a category';
        $auth->add($indexCategory);

        $updateCategory = $auth->createPermission('updateCategory');
        $updateCategory->description = 'Update a category';
        $auth->add($updateCategory);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230808_123743_create_permissions_for_actions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230808_123743_create_permissions_for_actions cannot be reverted.\n";

        return false;
    }
    */
}
