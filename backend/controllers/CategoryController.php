<?php

namespace backend\controllers;

use common\models\Category;
use common\models\search\SearchCategory;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CategoryController extends Controller
{
    /**
     * @param  $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Категорії з id: $id не знайдено");
        }

        return $this->render(
            'view', [
            'category' => $category,
            ]
        );
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $category = Category::find()->select(['title'])->where(['is_deleted' => false])->indexBy('id')->column();
        $categorySearch = new SearchCategory();
        $dataProvider = $categorySearch->search(Yii::$app->request->get());
        //методом search валідуємо данні які прийшли гет параметром,створюємо провайдер і фільтрацію.
        //Сформований обєкт віддаємо вюхі.

        return $this->render(
            'index', [
            'category' => $category,
            'categorySearch' => $categorySearch,
            'dataProvider' => $dataProvider,

            ]
        );
    }

    /**
     * @return string|Response
     */

    public function actionCreate()
    {
        $category = new Category();
        $parentCategories = Category::find()->select('title')->where(['is_deleted' => false])->indexBy('id')->column();

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            Yii::$app->session->setFlash('success', "Категорія '$category->title' успішно створена");
            return $this->redirect('index');

        } else {

            return $this->render(
                'create', [
                'category' => $category,
                'parentCategories' => $parentCategories
                ]
            );
        }
    }

    /**
     * @param  $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Категорії з id: $id не знайдено");
        }
        $parentCategories = Category::find()->select('title')->where(['is_deleted' => false])->indexBy('id')->column();

        if ($category->load(Yii::$app->request->post())) {
            $category->save();
            Yii::$app->session->setFlash('success', "Категорія '$category->title' успішно оновлена");
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render(
                'update', [
                'category' => $category,
                'parentCategories' => $parentCategories
                ]
            );
        }
    }

    /**
     * @param  $id
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $category = Category::findOne($id);
        $category->is_deleted = true;
        $category->save();
        Yii::$app->session->setFlash('success', "Категорія '$category->title' успішно видалена");
        return $this->redirect(['index']);
    }
}
