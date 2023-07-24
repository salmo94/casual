<?php

namespace backend\controllers;


use common\models\Category;
use common\models\search\SearchCategory;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Категорії з id: $id не знайдено");
        }

        return $this->render('view', [
            'category' => $category,
        ]);
    }

    /**
     * @return string
     */

    public function actionIndex()
    {
        $category  =  Category::find()->select(['title'])->where(['is_deleted' => false])->indexBy('id')->column();
        $categorySearch = new SearchCategory();
        $dataProvider = $categorySearch->search(Yii::$app->request->get());
        //методом search валідуємо данні які прийшли гет параметром,створюємо провайдер і фільтрацію.
        //Сформований обєкт віддаємо вюхі.

        return $this->render('index', [
            'category' => $category,
            'categorySearch' => $categorySearch,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $category = new Category();
        $parentCategory = Category::find()->select('title')->where(['is_deleted' => false])->indexBy('id')->column();

        if ($category->load(Yii::$app->request->post()) && $category->save()) {

            return $this->redirect('index');

        } else {

            return $this->render('create', [
                'category' => $category,
                'parentCategory' => $parentCategory
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionUpdate($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Категорії з id: $id не знайдено");
        }
        $parentCategory = Category::find()->select('title')->where(['is_deleted' => false])->indexBy('id')->column();

        if ($category->load(Yii::$app->request->post())) {
            $category->save();
            return $this->redirect(['view','id' => $id]);
        }

        else {
                return $this->render('update', [
                    'category' => $category,
                    'parentCategory' => $parentCategory
                ]);
            }
        }

    /**
     * @param $id
     * @return \yii\web\Response
     */

        public function actionDelete($id)
        {
            $category = Category::findOne($id);
            $category->is_deleted = true;
            $category->save();
            return $this->redirect(['index']);
        }

    }




