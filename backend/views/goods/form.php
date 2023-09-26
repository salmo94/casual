<?php
/**
 * @var yii\web\View $this
 * @var Goods $goods
 * @var yii\widgets\ActiveForm $form
 */

use common\models\Goods;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<?php $this->registerJsFile('@web/js/addGoodAttributes.js', ['depends' => 'yii\web\YiiAsset']) ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="right-column">
                <?php echo $form->field($goods, 'title')->input('text') ?>
                <?php echo $form->field($goods,'price')->input('number') ?>
                <?php echo $form->field($goods,'article')->input('text')?>
                <?php echo $form->field($goods,'available')->dropDownList(Goods::AVAILABILITY_TITLES) ?>
                <?php echo $form->field($goods,'status')->dropDownList(Goods::STATUS_TITLES)?>
                <?php echo $form->field($goods,'description')->textarea()?>
                <?= $form->field($goods, 'imageFiles[]')->fileInput(['multiple' => true,'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="col-6">
            <div class="left-column">
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
                <div id="goods-attributes">
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