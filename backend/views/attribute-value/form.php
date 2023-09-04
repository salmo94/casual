<?php
/**
 * @var yii\web\View $this
 * @var AttributeValue $attributeValue
 * @var yii\widgets\ActiveForm $form
 */

use common\models\AttributeValue;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin() ?>
            <?php echo $form->field($attributeValue, 'title')->textInput() ?>
            <?php echo $form->field($attributeValue, 'status')->dropDownList(AttributeValue::STATUS_TITLES) ?>
            <?php echo $form->field($attributeValue, 'attribute_id')->widget(Select2::class, [
                'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
                'language' => 'uk-UK',
                'initValueText' => $attributeValue->attr->title ?? '',
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'ajax' => [
                        'url' => Url::to(['attribute/autocomplete']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                ],
            ]) ?>
            <div class="mt-3">
                <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php $form = ActiveForm::end() ?>
        </div>
    </div>
</div>