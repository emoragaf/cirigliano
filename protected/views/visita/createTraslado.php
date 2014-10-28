<?php
/* @var $this VisitaController */
/* @var $model Visita */
?>

<?php
$this->breadcrumbs=array(
	Yii::t('app','model.Visita')=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>Yii::t('app','model.Visita.index'),'url'=>array('index')),
	array('label'=>Yii::t('app','model.Visita.admin'),'url'=>array('admin')),
);
?>
<h1> <?php echo Yii::t('app','model.Visita.createTraslado') ?></h1>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'visita-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>
<?php $this->renderPartial('/visita/_formTraslado', array('model'=>$model,'form'=>$form,'presupuesto'=>$presupuesto)); ?>
<div id="mueblepunto">
	<?php $this->renderPartial('/visita/_formPresupuestoTraslado', array('muebles'=>$muebles,'id'=>$id)); ?>
</div>


</div>
<?php $this->endWidget(); ?>