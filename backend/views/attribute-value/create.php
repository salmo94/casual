<?php
/**
 * @var yii\web\View $this
 * @var AttributeValue $attributeValue
 */

use common\models\AttributeValue;

?>

<?php $this->title = 'Значення атрибута';
$this->params['breadcrumbs'][] = ['label' => 'Список значень', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=$this->render('form',['attributeValue' => $attributeValue]);