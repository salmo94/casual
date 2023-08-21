<?php
namespace console\controllers;

use Exception;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->invalidateCache();
        echo 'ok';
    }

}