<?php

namespace backend\controllers\api;

use common\models\Category;
use yii\web\Controller;
use yii\web\Response;

class CategoryController extends Controller
{

    /**
     * @return Response
     */
    public function actionGetCategories():Response
    {
        $result = Category::getCategoriesTree();

        return $this->asJson(['categories' => $result]);
    }


    /**
     * @param int $categoryId
     * @return Response
     */
    public function actionGetSubCategories(int $categoryId): Response
    {
        $subCategories = Category::find()
            ->select(['id','title'])
            ->where(['parent_id' => $categoryId])
            ->asArray()
            ->all();

        return $this->asJson(['subCategories' => $subCategories]);
    }
}
