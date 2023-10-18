<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\Category;
use common\models\search\SearchCategory;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use function PHPUnit\Framework\assertDirectoryDoesNotExist;

class CategoryController extends Controller
{
//    /**
//     * @return array[]
//     */
//    public function behaviors(): array
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'only' => ['index', 'create', 'update'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['index'],
//                        'permissions' => ['indexCategory'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['create'],
//                        'permissions' => ['indexCategory'],
//                    ],
//                    [
//                        'allow' => true,
//                        'actions' => ['update'],
//                        'permissions' => ['updateCategory'],
//                    ],
//                ],
//            ],
//        ];
//    }



    public function actionIndex()
    {
        $categorySearch = new SearchCategory();
        $dataProvider = $categorySearch->search(Yii::$app->request->get());

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
            Yii::$app->session->setFlash('success', "Категорія '$category->title' створена");
            Yii::$app->telegram->sendMsg("Катерогія $category->title успішно створена");

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
            Yii::$app->session->setFlash('success', "Категорія '$category->title' оновлена");

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
        Yii::$app->session->setFlash('success', "Категорія '$category->title' видалена");

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

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionAddAttributes($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException("Категорії з id: $id не знайдено");
        }
        if (Yii::$app->request->isPost) {
            $postArrays = Yii::$app->request->post();
            $postData = [];
            if (isset($postArrays['Attribute'])) {
                $postData = $postArrays['Attribute'];
            }
            $errorAttrs = [];
            foreach ($postData as $data) {
                $attribute = new Attribute();
                $attribute->category_id = $category->id;
                $attribute->setAttributes($data);
                if (!$attribute->save()) {
                    $errorAttrs[] = "Атрибут :'$attribute->title' не було додано." . print_r($attribute->errors, true);
                }
            }
            if (!empty($errorAttrs)) {
                Yii::$app->session->setFlash('error', implode("<br>", $errorAttrs));
            } else {
                Yii::$app->session->setFlash('success', 'Атрибти успішо створено');
            }
            return $this->redirect('index');
        }
        return $this->render('add-attributes', [
            'category' => $category,
        ]);
    }


    public function actionGetCategories()
    {
        ///альтернативний варіант методу getCategoriesTree
//        $mainCategories = Category::find()
//            ->where(['parent_id' => null])
//            ->all();
//        $result = [];
//
//        /**
//         * @var $mainCategories Category[]
//         */
//        foreach ($mainCategories as $mainCategory) {
//            $categoryData = [
//                'id' => $mainCategory->id,
//                'title' => $mainCategory->title,
//                'child' => Category::getChildCategory($mainCategory->id),
//            ];
//            $result[] = $categoryData;
//        }


        $result = Category::getCategoriesTree();

        \Yii::$app->response->format = Response::FORMAT_JSON;
        \Yii::$app->response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080');

        return $this->asJson(['categories' => $result]);
    }
}
