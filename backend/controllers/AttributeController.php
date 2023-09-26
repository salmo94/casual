<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\AttributeValue;
use common\models\search\SearchAttribute;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
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


    public function actionGetByCategory(int $categoryId): Response
    {
        $attributes = Attribute::find()
            ->select(['id', 'title', 'type_id'])
            ->where([
                'category_id' => $categoryId,
                'status' => Attribute::STATUS_ACTIVE,
                'is_deleted' => false,
            ])
            ->with(['attrValue' => function (ActiveQuery $q) {
                $q->select(['id', 'title', 'attribute_id'])->indexBy('id');
            }])
            ->asArray()
            ->all();

        return $this->asJson($attributes);
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

    /**
     * @return Response
     */
    public function actionAddAjaxAttribute(): Response
    {
        $ajaxAttributes = Yii::$app->request->post();
        $attribute = new Attribute();
        $attribute->setAttributes($ajaxAttributes);
        if (!$attribute->save()) {
            return $this->asJson($attribute->errors);
        }
        return $this->asJson(['id' => $attribute->id]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws Exception
     */
    public function actionAddValues($id)
    {
        $attribute = Attribute::findOne($id);
        if (!$attribute) {
            throw new Exception("Атрибут з id:$attribute->id не знайдено");
        }
        if (Yii::$app->request->isPost) {
            $postArrays = Yii::$app->request->post();
            $postData = [];
            $errorValue = [];
            if (isset($postArrays['Value'])) {
                $postData = $postArrays['Value'];
            }
            foreach ($postData as $data) {
                $attributeValue = new AttributeValue();
                $attributeValue->attribute_id = $attribute->id;
                $attributeValue->setAttributes($data);
                $attributeValue->save();
                if (!$attributeValue->save()) {
                    $errorValue[] = "Значення :'$attributeValue->title' не було додано." . print_r($attributeValue->errors, true);
                }
                if (!empty($errorValue)) {
                    Yii::$app->session->setFlash('error', implode("<br>", $errorValue));
                } else {
                    Yii::$app->session->setFlash('success', 'Значення успішо створено');
                }
            }
            return $this->redirect('index');
        }
        return $this->render('add-values', [
            'attribute' => $attribute
        ]);
    }
}
