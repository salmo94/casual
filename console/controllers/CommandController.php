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
        $user->username = 'admin3';
        $user->email = 'admin3@email.com';
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->setPassword('admin777');
        $user->password = 'admin777';
        $user->save();
        echo 'OK';
    }

}