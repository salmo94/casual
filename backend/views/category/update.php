<?php
/**
 * @var yii\web\View $this
 * @var Category $category
 * @var yii\widgets\ActiveForm $form
 */

use common\models\Category;
?>

<?php $this->title = 'Редагування';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('form',['category' => $category]);