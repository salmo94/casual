<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\AttributeValue;
use common\models\Goods;
use common\models\search\SearchGoods;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class GoodsController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $goodsSearch = new SearchGoods();
        $dataProvider = $goodsSearch->search(Yii::$app->request->get());

        return $this->render('index', [
                'goodsSearch' => $goodsSearch,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id): string
    {
        $goods = Goods::findOne($id);
        return $this->render('view', [
            'goods' => $goods,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $goods = new Goods();

        if ($goods->load(Yii::$app->request->post())) {
            $goods->imageFiles = UploadedFile::getInstances($goods, 'imageFiles');
            if ($goods->save()) {
                $goods->upload();
                $postAttributes = Yii::$app->request->post('Attributes');
                Goods::setGoodsAttributes($postAttributes, $goods);
                Yii::$app->session->setFlash('success', "Товар '$goods->title' створений");

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', 'Не вдалося створити товар: ' . implode(', ', $goods->errors));
            }
        }
        return $this->render('create', [
            'goods' => $goods,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $goods = Goods::findOne($id);
        $attributeValueTitles = AttributeValue::find()
            ->select('title')
            ->where(['is_deleted' => false])
            ->indexBy('id')
            ->column();//todo доробити

        $attributeTitles = Attribute::find()
            ->select(['title'])
            ->where(['is_deleted' => false, 'category_id' => $goods->category_id])
            ->indexBy('id')
            ->column();//todo доробити
        if ($goods->load(Yii::$app->request->post()) && $goods->save()) {
            $postAttributes = Yii::$app->request->post('Attributes');
            Goods::updateGoodsAttributes($postAttributes, $id);
            Yii::$app->session->setFlash('success', "Товар '$goods->title' оновлено");

            return $this->redirect('index');
        }
        return $this->render('update', [
            'goods' => $goods,
            'attrBool' => $goods->boolAttributes,
            'attrDict' => $goods->dictAttributes,
            'attrFloat' => $goods->floatAttributes,
            'attrInt' => $goods->intAttributes,
            'attrText' => $goods->textAttributes,
            'attributeTitles' => $attributeTitles,
            'attributeValueTitles' => $attributeValueTitles,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionDelete($id)
    {
        $goods = Goods::findOne($id);
        $goods->is_deleted = true;
        if ($goods->save()) {
            Yii::$app->session->setFlash('success', "Товар '$goods->title' видалено");

            return $this->redirect('index');
        }
        Yii::$app->session->setFlash('danger', "Проблемка: $goods->errors");

        return '';
    }
}
