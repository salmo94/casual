<?php
/**
 * @var yii\web\View $this
 * @var Category $category
 */

use common\models\Category;
?>

<?php $this->title = 'Створення категорії';
$this->params['breadcrumbs'][] = ['label' => 'Список категорій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('form',['category' => $category]);
