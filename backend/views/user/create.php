<?php
/**
 * @var View $this
 * @var User $user
 * @var array $existRoles
 * @var array $roles
 */

use common\models\User;
use yii\web\View;

?>

<?php $this->title = 'Новий користувач';
$this->params['breadcrumbs'][] = ['label' => 'Список користувачів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form', [
    'user' => $user,
    'roles' => $roles,
    'existRoles' => $existRoles,
  ]);
