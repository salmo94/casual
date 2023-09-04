<?php
/**
 * @var yii\web\View $this
 * @var Category $category
 * @var yii\widgets\ActiveForm $form
 */

use common\models\Category;
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
            <?php echo $form->field($category, 'title')->textInput() ?>
            <?php echo $form->field($category, 'status')->dropDownList(Category::STATUS_TITLES) ?>
            <?php echo $form->field($category, 'parent_id')->widget(Select2::class, [
                'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
                'language' => 'uk-UK',
                'initValueText' => $category->parent->title ?? '',
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'ajax' => [
                        'url' => Url::to(['autocomplete']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
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