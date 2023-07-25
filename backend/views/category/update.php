<?php
/**
 * @var yii\web\View $this
 * @var Category $category
 * @var array $parentCategories
 * @var yii\widgets\ActiveForm $form
 */

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $this->title = 'Редагування';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-control">
    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
    <?php echo $form->field($category, 'title')->textInput()->label('Назва категорії') ?>
    <?php echo $form->field($category, 'status')->dropDownList([1 => 'Активний', 2 => 'Прихований'])->label('Статус') ?>
    <?php echo $form->field($category, 'parent_id')->dropDownList($parentCategories)->label('Батьківська категорія') ?>

    <div class="mt-3">
        <?php echo Html::submitButton('Оновити категорію', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Назад', 'index', ['class' => ' btn btn-success']); ?>
    </div>
    <?php $form = ActiveForm::end() ?>
</div>
