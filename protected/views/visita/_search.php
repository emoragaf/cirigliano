<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form CActiveForm */

if($tipo == 1){
    $filtroTipos = CHtml::listData(TipoVisita::model()->findAll(array('condition'=>'id = 1 or id = 2','order'=>'nombre')),'id','nombre');
}
else
    $filtroTipos = array();
$tipos = CHtml::listData(TipoVisita::model()->findAll(array('order'=>'nombre')),'id','nombre');
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<br>
	<div class="row well">
		<h4>Filtros</h4>
		<div class="row">
			<div class="span2">
				<?php echo $form->textFieldControlGroup($model,'folio',array('span'=>12)); ?>
	            <?php echo $form->textFieldControlGroup($model,'punto_direccion',array('span'=>12)); ?>
			</div>
			<div class="span2">
				<label for="Visita[punto_region_id]">Región</label>
	        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'name' => 'Visita[punto_region_id]',
                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Region::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
                    'pluginOptions' => array(
                        'placeholder' => 'Region',
                        'allowClear' => true,
                        'width' => '100%'
                    )
                    ),false);
                ?>
                <br>
                <br>
                <label for="Visita[punto_comuna_id]">Comuna</label>
	        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                    'name' => 'Visita[punto_comuna_id]',
                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Comuna::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
                    'pluginOptions' => array(
                        'placeholder' => 'Comuna',
                        'allowClear' => true,
                        'width' => '100%'
                    )
                    ),false);
                ?>
			</div>
			<div class="span2">
				<label for="Visita[tipo_visita_id]">Tipo Visita</label>
		        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
	                    'name' => 'Visita[tipo_visita_id]',
	                    'data' => array(''=>'',0=>'Todos') + $filtroTipos,
	                    'pluginOptions' => array(
	                        'placeholder' => 'Tipo Visita',
	                        'allowClear' => true,
	                        'width' => '100%'
	                    )
	                    ),false);
                ?>
                <br>
                <br>
                <label for="Visita[estado]">Estado</label>
		        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
	                    'name' => 'Visita[estado]',
	                    'data' => array(''=>'',0=>'Todos') + $model->Estados,
	                    'pluginOptions' => array(
	                        'placeholder' => 'Estado',
	                        'allowClear' => true,
	                        'width' => '100%'
	                    )
	                    ),false);
                ?>
			</div>
			<div class="span2">
				<label for="Visita[punto_distribuidor_id]">Tipo Visita</label>
		        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
	                    'name' => 'Visita[punto_distribuidor_id]',
	                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Distribuidor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
	                    'pluginOptions' => array(
	                        'placeholder' => 'Distribuidor',
	                        'allowClear' => true,
	                        'width' => '100%'
	                    )
	                    ),false);
                ?>
                <br>
                <br>
                <label for="Visita[punto_canal_id]">Canal</label>
		        	<?php $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
	                    'name' => 'Visita[punto_canal_id]',
	                    'data' => array(''=>'',0=>'Todos') + CHtml::listData(Canal::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),
	                    'pluginOptions' => array(
	                        'placeholder' => 'Canal',
	                        'allowClear' => true,
	                        'width' => '100%'
	                    )
	                    ),false);
                ?>
			</div>
			<div class="span3">
				<label for="">Fecha Creación</label>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                                        // 'model'=>$model,
	                                    'name' => 'Visita[fecha_creacion_inicio]',
	                                    'language' => 'es',
	                                        'value' => $model->fecha_creacion_inicio,
	                                    // additional javascript options for the date picker plugin
	                                    'options'=>array(
	                                        'showAnim'=>'fold',
	                                        'dateFormat'=>'dd-mm-yy',
	                                        'changeMonth' => 'true',
	                                        'changeYear'=>'true',
	                                        'constrainInput' => 'false',
	                                    ),
	                                    'htmlOptions'=>array(
	                                        'style'=>'height:20px;width:70px;',
	                                    ),
	// DONT FORGET TO ADD TRUE this will create the datepicker return as string
	                                ),false);?>
	                                -
	                      <?php          
								$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                                        // 'model'=>$model,
	                                    'name' => 'Visita[fecha_creacion_final]',
	                                    'language' => 'es',
	                                        'value' => $model->fecha_creacion_final,
	                                    // additional javascript options for the date picker plugin
	                                    'options'=>array(
	                                        'showAnim'=>'fold',
	                                        'dateFormat'=>'dd-mm-yy',
	                                        'changeMonth' => 'true',
	                                        'changeYear'=>'true',
	                                        'constrainInput' => 'false',
	                                    ),
	                                    'htmlOptions'=>array(
	                                        'style'=>'height:20px;width:70px',
	                                    ),
	// DONT FORGET TO ADD TRUE this will create the datepicker return as string
	                                ),false);?>
	                                <br>
	                                <label for="">Fecha Visita</label>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                                        // 'model'=>$model,
	                                    'name' => 'Visita[fecha_visita_inicio]',
	                                    'language' => 'es',
	                                        'value' => $model->fecha_visita_inicio,
	                                    // additional javascript options for the date picker plugin
	                                    'options'=>array(
	                                        'showAnim'=>'fold',
	                                        'dateFormat'=>'dd-mm-yy',
	                                        'changeMonth' => 'true',
	                                        'changeYear'=>'true',
	                                        'constrainInput' => 'false',
	                                    ),
	                                    'htmlOptions'=>array(
	                                        'style'=>'height:20px;width:70px;',
	                                    ),
	// DONT FORGET TO ADD TRUE this will create the datepicker return as string
	                                ),false);?>
	                                -
	                      <?php          
								$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	                                        // 'model'=>$model,
	                                    'name' => 'Visita[fecha_visita_final]',
	                                    'language' => 'es',
	                                        'value' => $model->fecha_visita_final,
	                                    // additional javascript options for the date picker plugin
	                                    'options'=>array(
	                                        'showAnim'=>'fold',
	                                        'dateFormat'=>'dd-mm-yy',
	                                        'changeMonth' => 'true',
	                                        'changeYear'=>'true',
	                                        'constrainInput' => 'false',
	                                    ),
	                                    'htmlOptions'=>array(
	                                        'style'=>'height:20px;width:70px',
	                                    ),
	// DONT FORGET TO ADD TRUE this will create the datepicker return as string
	                                ),false);?>
			</div>
		</div>
		<div class="row">
			<?php echo TbHtml::submitButton('Buscar',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
		</div>
	</div>
	


    <?php $this->endWidget(); ?>

</div><!-- search-form -->