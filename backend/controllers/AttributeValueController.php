<?php

namespace backend\controllers;

use common\models\AttributeValue;
use common\models\search\SearchAttributeValue;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AttributeValueController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchAttributeValue = new SearchAttributeValue();
        $dataProvider = $searchAttributeValue->search(Yii::$app->request->get());

        return $this->render('index', [
                'searchAttributeValue' => $searchAttributeValue,
                'dataProvider' => $dataProvider
            ]
        );
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $attributeValue = new AttributeValue();
        if ($attributeValue->load(Yii::$app->request->post()) && $attributeValue->save()) {
            Yii::$app->session->setFlash('success', "Значення '$attributeValue->title' створено");

            return $this->redirect('index');
        }
        return $this->render('create', [
            'attributeValue' => $attributeValue
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $attributeValue = AttributeValue::findOne($id);
        if (!$attributeValue) {
            throw new NotFoundHttpException("Значення з id: $id не знайдено");
        }
        if ($attributeValue->load(Yii::$app->request->post()) && $attributeValue->save()) {
            Yii::$app->session->setFlash('success', "Значення '$attributeValue->title' оновлено");
            return $this->redirect('index');
        }
        return $this->render('update', [
            'attributeValue' => $attributeValue,
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $attributeValue = AttributeValue::findOne($id);
        $attributeValue->is_deleted = true;
        $attributeValue->save();
        Yii::$app->session->setFlash('success', "Значення '$attributeValue->title' видалено");

        return $this->redirect('index');
    }
}
