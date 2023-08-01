<?php
/**
 * @var yii\web\View $this
 * @var Attribute $attribute
 */

use common\models\Attribute;
?>

<?php $this->title = 'Створення атрибута';
$this->params['breadcrumbs'][] = ['label' => 'Список атрибутів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('form',['attribute' => $attribute]);