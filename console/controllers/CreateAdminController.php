<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;


class CreateAdminController extends Controller
{
    public function actionDefault()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@email.com';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('admin777');
        $user->password = 'admin777';
        $user->generateAuthKey();
        $user->save();
    }

    public function actionRole()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin,$auth->getPermission('createCategory'));
        $auth->addChild($admin,$auth->getPermission('indexCategory'));
        $auth->addChild($admin,$auth->getPermission('updateCategory'));
        $auth->addChild($admin,$auth->getPermission('createAttribute'));
        $auth->addChild($admin,$auth->getPermission('updateAttribute'));
        $auth->addChild($admin,$auth->getPermission('deleteAttribute'));
        $auth->addChild($admin,$auth->getPermission('indexUser'));
        $auth->addChild($admin,$auth->getPermission('createUser'));
        $auth->addChild($admin,$auth->getPermission('updateUser'));
        $auth->addChild($admin,$auth->getPermission('deleteUser'));
        $auth->addChild($admin,$auth->getPermission('indexAttribute'));

        $auth->assign($admin,1);
    }
}
