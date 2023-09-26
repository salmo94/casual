<?php
/**
 * @var yii\web\View $this
 * @var Goods $goods
 */

use common\models\Goods;

?>

<?php $this->title = 'Створення товару';
$this->params['breadcrumbs'][] = ['label' => 'Список товарів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('form', ['goods' => $goods]);
