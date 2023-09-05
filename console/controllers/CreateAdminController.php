<?php

namespace console\controllers;

use common\components\Telegram;
use common\models\Category;
use common\models\User;
use yii\console\Controller;
use yii\httpclient\Client;

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

}