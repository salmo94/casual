<?php

use yii\db\Migration;

/**
 * Class m230808_124426_create_permissions_for_actions1
 */
class m230808_124426_create_permissions_for_actions1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $indexAttribute = $auth->createPermission('indexAttribute');
        $indexAttribute->description = 'Перегляд атрибутів';
        $auth->add($indexAttribute);

        $createAttribute = $auth->createPermission('createAttribute');
        $createAttribute->description = 'Створення атрибутів';
        $auth->add($createAttribute);

        $updateAttribute = $auth->createPermission('updateAttribute');
        $updateAttribute->description = 'Оновлення атрибутів';
        $auth->add($updateAttribute);

        $deleteAttribute = $auth->createPermission('deleteAttribute');
        $deleteAttribute->description = 'Видалення атрибутів';
        $auth->add($deleteAttribute);

        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = 'Перегляд користувачів';
        $auth->add($indexUser);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Створення нових користувачів';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Оновлення даних користувачів';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Видалення атрибутів';
        $auth->add($deleteUser);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230808_124426_create_permissions_for_actions1 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230808_124426_create_permissions_for_actions1 cannot be reverted.\n";

        return false;
    }
    */
}
