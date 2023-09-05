<?php
namespace console\controllers;

use common\components\Telegram;
use common\models\Category;
use common\models\User;
use yii\console\Controller;
use yii\httpclient\Client;

class CommandController extends Controller
{

    public function actionAdd()
    {

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@email.com';
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword('admin');
        $user->generateAuthKey();
        $user->save();
        echo 'OK';
    }

}