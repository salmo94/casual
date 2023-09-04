<?php
/**
 * @var Attribute $attribute
 */

use backend\assets\AppAsset;
use common\models\Attribute;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $this->registerJsFile('@web/js/addValues.js', ['depends' => 'yii\web\YiiAsset']) ?>
<?php AppAsset::register($this)?>
<?php $this->title = "Додати значення атрибуту: $attribute->title";
$this->params['breadcrumbs'][] = ['label' => 'Список атрибутів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<div class="row">
    <div id="addForm" class="col-md-7  pl-2">
        <table class="table-value ml-5">
            <tr>
                <th class="value-name">Назва значення</th>
                <th>Статус</th>
            </tr>
        </table>
        <div class="oneForm ">

            <div class="input-group mb-3">

                <div class="title-container">
                    <?= Html::input('text', "", null, ['data-name' => 'title', 'class' => 'form-control','required']) ?>
                    <div class="help-block"></div>
                </div>

                <div class="status-container">
                    <?= Html::dropDownList("", null, Attribute::STATUS_TITLES, [
                        'data-name' => 'status',
                        'class' => 'form-control ml-2']) ?>
                    <div class="help-block ml-3"></div>
                </div>
                <?php echo Html::a(false,false,['class'=>"fa-solid fa-xmark fa-2xl mt-3 ml-3 delete-value-button"])?>
                <?php echo Html::a(false,false,['class'=>"fa-solid fa-check fa-2xl mt-3 ml-2 send-value-button"])?>
            </div>
        </div>

    </div>
</div>
<div class=" mt-2">
    <?php echo Html::a(false,false,['id' => 'add-value-button','class'=>'fa-solid fa-square-plus fa-2xl ml-2'])?>
</div>
<div class="mt-3">

    <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
</div>

<?php $form = ActiveForm::end() ?>
