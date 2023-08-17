<?php

/**
 * @var View $this
 * @var ActiveForm $form
 * @var User $user
 * @var array $roles
 * @var array $existRoles
 */

use common\models\User;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>
<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($user, 'email')->textInput() ?>
            <?= $form->field($user, 'status')->dropDownList(User::USER_STATUSES) ?>
            <?= $form->field($user, 'password')->passwordInput() ?>
            <?php echo Html::label('Роль') ?><br>
            <?php foreach ($roles as $role): ?>
                <?php $isChecked = in_array($role['name'], $existRoles) ?>
                <?php echo Html::checkbox('role[' . $role['name'] . ']', $isChecked,
                    ['label' => sprintf('%s (%s)', $role['name'], $role['description'])]) ?><br>
            <?php endforeach; ?>
            <div class="form-group">
                <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
