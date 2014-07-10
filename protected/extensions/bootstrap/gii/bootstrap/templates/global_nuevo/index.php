<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$label="Yii::t('app','model.".$this->class2name($this->modelClass)."')\n";
echo "\$this->breadcrumbs=array(
	$label,
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo ".$label.";?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>