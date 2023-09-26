<?php
/**
 * @var yii\web\View $this
 * @var array $goods
 * @var array $attrBool
 * @var array $attrDict
 * @var array $attrFloat
 * @var array $attrInt
 * @var array $attrText
 * @var array $attributeTitles
 * @var array $attributeValueTitles
 */

use common\models\Goods;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

?>

<?php $this->title = 'Оновлення товару';
$this->params['breadcrumbs'][] = ['label' => 'Список товарів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="right-column">
                <?php echo $form->field($goods, 'title')->input('text') ?>
                <?php echo $form->field($goods, 'price')->input('number') ?>
                <?php echo $form->field($goods, 'article')->input('text') ?>
                <?php echo $form->field($goods, 'available')->dropDownList(Goods::AVAILABILITY_TITLES) ?>
                <?php echo $form->field($goods, 'status')->dropDownList(Goods::STATUS_TITLES) ?>
                <?php echo $form->field($goods, 'description')->textarea() ?>
            </div>
        </div>
        <div class="col-6">
            <div class="left-column">
                <div id="goods-attributes">
                    <div class="form-group field-category">
                        <?php echo $form->field($goods, 'category_id')->widget(Select2::class, [
                            'options' => ['id' => 'goods-category', 'placeholder' => 'Натисніть щоб вибрати...'],
                            'language' => 'uk-UK',
                            'initValueText' => $goods->category->title ?? '',
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 2,
                                'ajax' => [
                                    'url' => Url::to(['category/autocomplete']),
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="form-group field-attributes-text">
                        <?php foreach ($attrText as $text): ?>
                            <?php echo Html::label($attributeTitles[$text['attribute_id']]) ?>
                            <?php echo Html::input('text', 'Attributes' . '[' . $text['attribute_id'] . ']', $text['value'], ['class' => 'form-control']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group field-attributes-int">
                        <?php foreach ($attrInt as $int): ?>
                            <?php echo Html::label($attributeTitles[$int['attribute_id']]) ?>
                            <?php echo Html::input('number', 'Attributes' . '[' . $int['attribute_id'] . ']', $int['value'], ['class' => 'form-control']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group field-attributes-float">
                        <?php foreach ($attrFloat as $float): ?>
                            <?php  echo Html::label($attributeTitles[$float['attribute_id']]) ?>
                            <?php echo Html::input('number', 'Attributes' . '[' . $float['attribute_id'] . ']', $float['value'], ['class' => 'form-control', 'step' => 'any']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group field-attributes-dictionary">
                        <?php foreach ($attrDict as $dict): ?>
                            <?php echo Html::label($attributeTitles[$dict['attribute_id']]) ?>
                            <?php echo Html::dropDownList('Attributes' . '[' . $dict['attribute_id'] . ']', $attributeValueTitles[$dict['value_id']], $attributeValueTitles, ['class' => 'form-control']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group field-attributes-bool">
                        <?php foreach ($attrBool as $bool): ?>
                            <?php $isChecked = in_array($bool['attribute_id'], array_flip($attributeTitles)) ?>
                            <?php echo Html::checkbox('Attributes' . '[' . $bool['attribute_id'] . ']', $isChecked, ['label' => $attributeTitles]) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php $form = ActiveForm::end() ?>
</div>
<style>
    .container {
        max-width: 100%;
    }

    .right-column {
        width: 500px;
    }

    .left-column {
        width: 500px;
    }
</style>
