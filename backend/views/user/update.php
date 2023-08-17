<?php
/**
 * @var View $this
 * @var array $user
 * @var array $roles
 * @var array $existRoles
 */

use yii\web\View;

?>
<?php $this->title = 'Оновлення даних';
$this->params['breadcrumbs'][] = ['label' => 'Список користувачів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form', [
    'user' => $user,
    'roles' => $roles,
    'existRoles' => $existRoles
]);
