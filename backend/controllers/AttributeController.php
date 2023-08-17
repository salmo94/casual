<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\search\SearchAttribute;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AttributeController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'permissions' => ['indexAttribute'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'permissions' => ['createAttribute'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'permissions' => ['updateAttribute'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'permissions' => ['deleteAttribute'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $attributeSearch = new SearchAttribute();
        $dataProvider = $attributeSearch->search(Yii::$app->request->get());

        return $this->render('index', [
                'attributeSearch' => $attributeSearch,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $attribute = new Attribute();
        if ($attribute->load(Yii::$app->request->post()) && $attribute->save()) {
            Yii::$app->session->setFlash('success', "Атрибут '$attribute->title' створений");

            return $this->redirect('index');
        }
        return $this->render('create', [
            'attribute' => $attribute
        ]);
    }

    /**
     * @param  $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $attribute = Attribute::findOne($id);
        if (!$attribute) {
            throw new NotFoundHttpException("Атрибут з id: $id не знайдено");
        }
        if ($attribute->load(Yii::$app->request->post()) && $attribute->save()) {
            Yii::$app->session->setFlash('success', "Атрибут '$attribute->title' оновлений");

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'attribute' => $attribute,
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
        $attribute = Attribute::findOne($id);
        $attribute->is_deleted = true;
        $attribute->save();
        Yii::$app->session->setFlash('success', "Атрибут '$attribute->title' видалений");

        return $this->redirect(['index']);
    }

    /**
     * @param string $q
     * @return Response
     */
    public function actionAutocomplete(string $q): Response
    {
        $attributes = Attribute::find()
            ->select(['text' => 'title', 'id'])
            ->where(['is_deleted' => false])
            ->andWhere(['like', 'title', $q])
            ->orderBy('title')
            ->limit(100)
            ->asArray()
            ->all();

        return $this->asJson(
            ['results' => $attributes]
        );
    }
}
