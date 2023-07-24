<?php

/**
 * @var yii\web\View $this
 * @var Category $category
 * @var Category $parentCategory
 * @var yii\widgets\ActiveForm $form
 *
 */

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редагування';

?>

<div class="form-control">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin()?>

    <?= $form->field($category,'title')->textInput()->label('Назва категорії')?>

    <?= $form->field($category,'status')->dropDownList([1 => 'Активний',2 => 'Прихований',3 => 'Тимчасово прихований'])->label('Статус')?>

    <?= $form->field($category,'parent_id')->dropDownList($parentCategory)->label('Батьківська категорія') ?>

    <div class="mt-3">
        <?= Html::submitButton('Оновити категорію',['class' => 'btn btn-primary'])?>

        <?php  echo Html::a('Назад','index',['class' =>  ' btn btn-success']);?>
    </div>
    <div class="mt-3">

    </div>
    <?php $form = ActiveForm::end()?>
</div>
