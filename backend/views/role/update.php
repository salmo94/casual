<?php
/**
 * @var View $this
 * @var array $role
 * @var array $permissions
 * @var array $existPermissions
 */

use yii\web\View;

?>

<?php $this->title = 'Редагування';
$this->params['breadcrumbs'][] = ['label' => 'Список ролей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form', [
    'role' => $role,
    'permissions' => $permissions,
    'existPermissions' => $existPermissions
]);
