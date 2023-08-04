<?php
/**
 * @var yii\web\View $this
 * @var Attributevalue $attributeValue
 */

use common\models\AttributeValue;

?>

<?php $this->title = 'Оновлення значення';
$this->params['breadcrumbs'][] = ['label' => 'Список значень', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('form',['attributeValue' => $attributeValue]);
