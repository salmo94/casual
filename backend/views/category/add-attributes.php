<?php
/**
 * @var Category $category
 */

use backend\assets\AppAsset;
use common\models\Attribute;
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $this->registerJsFile('@web/js/addAttributes.js', ['depends' => 'yii\web\YiiAsset']) ?>
<?php AppAsset::register($this)?>
<?php $this->title = "Додати атрибути категорії: $category->title";
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableAjaxValidation' => true,
]) ?>

<div class="row">
    <div id="addForm" class="col-md-7  pl-2">
        <table class="table-attr ml-5">
            <tr>
                <th class="attr-name">Назва атрибуту</th>
                <th class="attr-status">Статус</th>
                <th>Тип атрибуту</th>
            </tr>
        </table>
        <div class="oneForm ">
            <div class="input-group mb-3">
                <div class="title-container">
                    <?= Html::input('text', "", null, ['data-name' => 'title', 'class' => 'form-control', 'required']) ?>
                    <div class="help-block"></div>
                </div>
                <div class="status-container">
                    <?= Html::dropDownList("", null, Attribute::STATUS_TITLES, [
                        'data-name' => 'status',
                        'class' => 'form-control ml-2']) ?>
                    <div class="help-block ml-3"></div>
                </div>
                <div class="type-container ml-2">
                    <?= Html::dropDownList("", null, Attribute::TYPE_TITLES, [
                        'data-name' => 'type',
                        'class' => 'form-control',
                        'prompt' => 'Виберіть тип...'
                    ]) ?>
                    <div class="help-block ml-3"></div>
                </div>
                <?php echo Html::a(false, false, ['class' => "fa-solid fa-xmark fa-2xl mt-3 ml-3 delete-attribute-button"]) ?>
                <?php echo Html::a(false, false, ['class' => "fa-solid fa-check fa-2xl mt-3 ml-2 send-attribute-button"]) ?>
            </div>

        </div>
    </div>
</div>
<div class=" mt-2">
    <?php echo Html::a(false, false, ['id' => 'add-attribute-button', 'class' => 'fa-solid fa-square-plus fa-2xl ml-2']) ?>
</div>
<div class="mt-3">
    <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form = ActiveForm::end() ?>
