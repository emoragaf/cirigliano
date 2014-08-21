<?php
/* @var $this FormularioController */
/* @var $model Formulario */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'formulario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>
		
	<?php foreach ($campos as $campo): ?>

		<?php
			$campo->entidad = str_replace('[', '', $campo->entidad);
			$campo->entidad = str_replace(']', '', $campo->entidad);
			if (strpos($campo->entidad,'n:') !== false) {
			    $foo = explode(':', $campo->entidad);
			    foreach ($$foo[1] as $mueble) {
			    	if(strpos($campo->nombre,'%n') !== false){
			    		$campo->nombre = str_replace('%n', $mueble->mueblepunto->mueble->descripcion.' '.$mueble->mueblepunto->codigo, $campo->nombre);
			    		$fieldname = str_replace(' ', '', $campo->nombre);
			    		echo $campo->nombre.'<br><br>';
			    		if($campo->tipo->nombre == 'FotoMultiple'){
							$this->widget(
							    'yiiwheels.widgets.fileupload.WhFileUpload',
							    array(
							        'name'     => $fieldname,
							        'url'      => $this->createUrl('site/upload', array('type' => 'fine')),
							        'multiple' => true,
							    )
							);
			    		}
			    		if($campo->tipo->nombre == 'FotoSimple'){
							$this->widget(
							    'yiiwheels.widgets.fileupload.WhFileUpload',
							    array(
							        'name'     => $fieldname,
							        'url'      => $this->createUrl('site/upload', array('type' => 'fine')),
							        'multiple' => false,
							    )
							);
			    		}
			    	}
			    }
			}
			else {
				echo $campo->nombre.'<br><br>';
				$fieldname = str_replace(' ', '', $campo->nombre);
				if($campo->tipo->nombre == 'FotoMultiple'){
							$this->widget(
							    'yiiwheels.widgets.fileupload.WhFileUpload',
							    array(
							        'name'     => $fieldname,
							        'url'      => $this->createUrl('site/upload', array('type' => 'fine')),
							        'multiple' => true,
							    )
							);
			    		}
			    		if($campo->tipo->nombre == 'FotoSimple'){
							$this->widget(
							    'yiiwheels.widgets.fileupload.WhFileUpload',
							    array(
							        'name'     => $fieldname,
							        'url'      => $this->createUrl('site/upload', array('type' => 'fine')),
							        'multiple' => false,
							    )
							);
			    		}
			}


		?>
	
	<?php endforeach ?>

        <?php echo $form->textAreaControlGroup($model,'notas',array('rows'=>6,'span'=>8)); ?>

        <div>
        <?php echo TbHtml::submitButton('Aceptar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->