<?php
/**
 * @var View $this
 * @var Role $role
 * @var array $permissions
 * @var array $existPermissions
 */

use common\models\Role;
use yii\web\View;

?>

<?php $this->title = ' Нова роль';
$this->params['breadcrumbs'][] = ['label' => 'Список ролей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form', [
    'role' => $role,
    'permissions' => $permissions,
    'existPermissions' => $existPermissions
]);
