<?php

namespace common\models;

use common\models\goods_attribute\GoodsAttributeBool;
use common\models\goods_attribute\GoodsAttributeDictionary;
use common\models\goods_attribute\GoodsAttributeFloat;
use common\models\goods_attribute\GoodsAttributeInt;
use common\models\goods_attribute\GoodsAttributeText;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * @property string $title
 * @property string $description
 * @property string $article
 * @property string $available
 * @property integer $id
 * @property integer $price
 * @property integer $category_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $is_deleted
 * @property-read Category $category
 * @property-read GoodsAttributeText $textAttributes
 * @property-read GoodsAttributeInt $intAttributes
 * @property-read GoodsAttributeFloat $floatAttributes
 * @property-read GoodsAttributeDictionary $dictAttributes
 * @property-read GoodsAttributeBool $boolAttributes
 * @property-read GoodsImage $goodsImages
 */
class Goods extends BaseModel
{

    /**
     * @var UploadedFile[]
     */
    public array $imageFiles = [];

    public const AVAILABILITY_AVAILABLE = 1;
    public const AVAILABILITY_UNAVAILABLE = 2;
    public const AVAILABILITY_WAITING_FOR_SUPPLY = 3;

    public const AVAILABILITY_TITLES = [
        self::AVAILABILITY_AVAILABLE => 'В наявності',
        self::AVAILABILITY_UNAVAILABLE => 'Немає в наявності',
        self::AVAILABILITY_WAITING_FOR_SUPPLY => 'Очікується',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'goods';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'description', 'article'], 'string'],
            [['id', 'price', 'category_id', 'status', 'available'], 'integer'],
            ['is_deleted', 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Назва товару',
            'description' => 'Опис',
            'price' => 'Ціна',
            'article' => 'Код товару',
            'available' => 'Наявність',
            'status' => 'Статус',
            'imageFiles' => 'Зображення',
            'category_id' => 'Категорія',
            'created_at' => 'Дата створення',
        ];
    }


    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload(): bool
    {
        if ($this->validate(['imageFiles'])) {
            FileHelper::createDirectory('images/' . $this->id);
            foreach ($this->imageFiles as $file) {
                $path = 'images/' . $this->id . '/' . $file->baseName . '.' . $file->extension;
                $isFileSaved = $file->saveAs($path);
                if ($isFileSaved) {
                    $goodsImage = new GoodsImage();
                    $goodsImage->goods_id = $this->id;
                    $goodsImage->image_path = $path;
                    $goodsImage->save();
                }
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return ActiveQuery
     */
    public function getGoodsImages(): ActiveQuery
    {
        return $this->hasMany(GoodsImage::class,['goods_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTextAttributes(): ActiveQuery
    {
        return $this->hasMany(GoodsAttributeText::class, ['goods_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getIntAttributes(): ActiveQuery
    {
        return $this->hasMany(GoodsAttributeInt::class, ['goods_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFloatAttributes(): ActiveQuery
    {
        return $this->hasMany(GoodsAttributeFloat::class, ['goods_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDictAttributes(): ActiveQuery
    {
        return $this->hasMany(GoodsAttributeDictionary::class, ['goods_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBoolAttributes(): ActiveQuery
    {
        return $this->hasMany(GoodsAttributeBool::class, ['goods_id' => 'id']);
    }

    /**
     * @param array $postAttributes
     * @param Goods $goods
     * @return void
     */
    public static function setGoodsAttributes(array $postAttributes, Goods $goods)
    {
        foreach ($postAttributes as $attrId => $value) {
            $typeId = Attribute::find()
                ->select(['type_id'])
                ->where(['id' => $attrId, 'is_deleted' => false])
                ->asArray()
                ->scalar();
            switch ($typeId) {
                case Attribute::TYPE_TEXT:
                    GoodsAttributeText::setAttributeText($goods->id, $attrId, $value);
                    break;
                case Attribute::TYPE_INTEGER:
                    GoodsAttributeInt::setAttributesInt($goods->id, $attrId, $value);
                    break;
                case Attribute::TYPE_FLOAT:
                    GoodsAttributeFloat::setAttributesFloat($goods->id, $attrId, $value);
                    break;
                case  Attribute::TYPE_DICTIONARY:
                    GoodsAttributeDictionary::setAttributesDict($goods->id, $attrId, $value);
                    break;
                case Attribute::TYPE_BOOL:
                    GoodsAttributeBool::setAttributeBool($goods->id, $attrId);
                    break;
                default:
                    Yii::$app->session->setFlash('danger', "Помилочка");
            }
        }
    }

    /**
     * @param array $postAttributes
     * @param int $id
     * @return void
     */
    public static function updateGoodsAttributes(array $postAttributes, int $id)
    {
        GoodsAttributeBool::deleteAll(['goods_id' => $id]);
        foreach ($postAttributes as $attrId => $value) {
            $typeId = Attribute::find()
                ->select(['type_id'])
                ->where(['id' => $attrId, 'is_deleted' => false])
                ->asArray()
                ->scalar();
            switch ($typeId) {
                case Attribute::TYPE_TEXT:
                    $goodsText = GoodsAttributeText::findOne(['goods_id' => $id, 'attribute_id' => $attrId]);
                    $goodsText->value = $value;
                    $goodsText->save();
                    break;
                case Attribute::TYPE_INTEGER:
                    $goodsInt = GoodsAttributeInt::findOne(['goods_id' => $id, 'attribute_id' => $attrId]);
                    $goodsInt->value = $value;
                    $goodsInt->save();
                    break;
                case Attribute::TYPE_FLOAT:
                    $goodsFloat = GoodsAttributeFloat::findOne(['goods_id' => $id, 'attribute_id' => $attrId]);
                    $goodsFloat->value = $value;
                    $goodsFloat->save();
                    break;
                case  Attribute::TYPE_DICTIONARY:
                    $goodsDict = GoodsAttributeDictionary::findOne(['goods_id' => $id, 'attribute_id' => $attrId]);
                    $goodsDict->value_id = $value;
                    $goodsDict->save();
                    break;
                case Attribute::TYPE_BOOL:
                    GoodsAttributeBool::setAttributeBool($id, $attrId);
                    break;
                default:
                    Yii::$app->session->setFlash('danger', "Помилочка");
            }
        }
    }
}
