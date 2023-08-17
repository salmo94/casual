<?php

namespace backend\controllers;

use common\models\search\SearchPermission;
use Yii;
use yii\web\Controller;

class PermissionController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchRole = new SearchPermission();
        $dataProvider = $searchRole->search(Yii::$app->request->get());

        return $this->render('index', [
                'searchRole' => $searchRole,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
