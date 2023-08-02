<?php
/**
 * @var yii\web\View $this
 * @var Attribute $attribute
 * @var yii\widgets\ActiveForm $form
 */

use common\components\helpers\CustomWidgetsHelper;
use common\models\Attribute;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="form-control">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
    <?php echo $form->field($attribute, 'title')->textInput() ?>
    <?php echo $form->field($attribute, 'status')->dropDownList(Attribute::STATUS_TITLES) ?>
    <?php echo $form->field($attribute, 'type_id')->dropDownList(Attribute::TYPE_TITLES)?>
    <?php echo $form->field($attribute, 'category_id')->widget(Select2::class, [
        'options' => ['placeholder' => 'Натисніть щоб вибрати...'],
        'language' => 'uk-UK',
        'pluginOptions' => CustomWidgetsHelper::getSelect2PluginOptions()
    ]) ?>
    <div class="mt-3">
        <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php $form = ActiveForm::end() ?>
</div>
