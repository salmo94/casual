<?php
/**
 * @var View $this
 * @var ActiveForm $form
 * @var Role $role
 * @var array $permissions
 * @var array $existPermissions
 */

use common\models\Role;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($role, 'name')->textInput() ?>
<?php echo $form->field($role, 'description')->textInput() ?>
<?php echo Html::label('Права доступу') ?><br>
<?php foreach ($permissions as $permission): ?>
    <?php $isChecked = in_array($permission['name'], $existPermissions) ?>
    <?php echo Html::checkbox('permission[' . $permission['name'] . ']', $isChecked,
        ['label' => sprintf('%s (%s)', $permission['name'], $permission['description'])]) ?><br>
<?php endforeach; ?>
<div class="mt-3">
    <?php echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form = ActiveForm::end() ?>
