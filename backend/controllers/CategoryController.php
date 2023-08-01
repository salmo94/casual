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
     * @return string
     */
    public function actionIndex(): string
    {
        $categorySearch = new SearchCategory();
        //методом search валідуємо данні які прийшли гет параметром,створюємо провайдер і фільтрацію.
        $dataProvider = $categorySearch->search(Yii::$app->request->get());
        //Сформований обєкт віддаємо вюхі.
        return $this->render('index', [
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
        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            Yii::$app->session->setFlash('success', "Категорія '$category->title' успішно створена");
            Yii::$app->telegram->sendMsg("Катерогія $category->title успішно створена: $category->created_at");

            return $this->redirect('index');
        } else {
            return $this->render('create', [
                    'category' => $category,
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
        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            Yii::$app->session->setFlash('success', "Категорія '$category->title' успішно оновлена");

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'category' => $category,
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

    /**
     * @param string $q
     * @return Response
     */
    public function actionAutocomplete(string $q): Response
    {
        $categories = Category::find()
            ->select(['id', 'text' => 'title'])
            ->where(['is_deleted' => false])
            ->andWhere(['ilike', 'title', $q])
            ->orderBy('title')
            ->limit(100)
            ->asArray()
            ->all();

        return $this->asJson(
            ['results' => $categories]
        );
    }
}
