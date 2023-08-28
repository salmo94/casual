<?php
/**
 * @var Category $category
 * @var Attribute $attribute
 */

use common\models\Attribute;
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<?php $this->registerJsFile('@web/js/addAttributes.js', ['depends' => 'yii\web\YiiAsset']) ?>

<?php $this->title = "Додати атрибути категорії: $category->title";
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
    <div class="row">
        <div id="addForm" class="col-lg-5">
            <div class="oneForm">
                <?= Html::label('Назва атрибуту', null, ['class' => 'control-label']) ?>
                <?= Html::input('text', "", null, [ 'id' => 'title','data-name' => 'title', 'class' => 'form-control','required']) ?>
                <?= Html::label('Статус', null, ['class' => 'control-label']) ?>
                <?= Html::dropDownList("", null, Attribute::STATUS_TITLES, [
                    'data-name' => 'status',
                    'class' => 'form-control']) ?>
                <?= Html::label('Тип атрибуту', null, ['class' => 'control-label']) ?>
                <?= Html::dropDownList("", null, Attribute::TYPE_TITLES, [
                    'data-name' => 'type',
                    'id' => 'type_id',
                    'class' => 'form-control',
                    'prompt' => 'Виберіть тип...'
                ]) ?>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::button('Додати ще', ['id' => 'add-attribute-button', 'class' => 'btn btn-success']) ?>
        <?php echo Html::button('Видалити', ['id' => 'delete-attribute-button','class' => 'btn btn-danger']) ?>
    </div>
<?php $form = ActiveForm::end() ?>
