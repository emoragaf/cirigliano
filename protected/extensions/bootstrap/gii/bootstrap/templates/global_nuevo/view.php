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
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label="Yii::t('app','model.".$this->class2name($this->modelClass)."')";
echo "\$this->breadcrumbs=array(
	$label=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.create'),'url'=>array('create')),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.update'),'url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.delete'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app','model.<?php echo $this->modelClass;?>.admin'),'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo Yii::t('app','model.".$this->modelClass.".view');?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
<?php
foreach ($this->tableSchema->columns as $column) {
    echo "\t\t'" . $column->name . "',\n";
}
?>
	),
)); ?>