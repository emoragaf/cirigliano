<?php
/**
 * The following variables are available in this template:
 * - $this: the BootstrapCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
<?php echo "?>\n"; ?>

<?php
echo "<?php\n";
$label="Yii::t('app','model.".$this->class2name($this->modelClass)."')";
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	'Crear',
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo " <?php echo Yii::t('app','model.".$this->modelClass.".create'); ?>"; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>