<?php
/* @var $this FormularioController */
/* @var $model Formulario */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php 
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array( 
    	'enableAjaxValidation'=>true, 'id'=>'formulario-form',
    	'htmlOptions'=>array('enctype'=>'multipart/form-data', ), ));
?>

    <p class="help-block"><?php echo Yii::t('app','Fields with * are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>
 
	<?php foreach ($campos as $campo): ?>
		<?php
			$campo->entidad = str_replace('[', '', $campo->entidad);
			$campo->entidad = str_replace(']', '', $campo->entidad);
			if (strpos($campo->entidad,'n:') !== false) {
			    $foo = explode(':', $campo->entidad);
			    foreach ($$foo[1] as $mueble) {
			    		$nombre = $campo->nombre;
			    		//echo $mueble->codigo;
			    	if(strpos($nombre,'%n') !== false){
			    		$id = str_replace('%n', '', $nombre);
			    		$nombre = str_replace('%n', $mueble->mueble->descripcion.' '.$mueble->codigo, $nombre);
			    		//$fieldname = 'Foto_'.$id.'['.$mueble->id.']';
			    		$fieldname = 'Foto'.str_replace(' ', '', $id).$mueble->id;
			    		echo '<div class="well">';
			    		echo '<h4>'.$nombre.'</h4><br>';
			    		if($campo->tipo->nombre == 'FotoMultiple'){
			    			
						    $this->widget('CMultiFileUpload', array(
					            'name' => $fieldname,
					            'id'=>$fieldname,
					            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
					            'duplicate' => 'Archivo Duplicado!', // useful, i think
					            'denied' => 'Tipo archivo inválido', // useful, i think
					        ));

			    		}
			    		if($campo->tipo->nombre == 'FotoSimple'){
							echo CHtml::fileField($fieldname, '', array('id'=>$fieldname));

			    		}
			    		echo '</div>';
			    	}
			    }
			}
			else {
				echo '<div class="well">';
				echo '<h4>'.$campo->nombre.'</h4><br>';
				$fieldname = str_replace(' ', '', $campo->nombre);
				if($campo->tipo->nombre == 'FotoMultiple'){
					 $this->widget('CMultiFileUpload', array(
		            'name' => $fieldname,
		            'id'=>$fieldname,
		            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
		            'duplicate' => 'Archivo Duplicado!', // useful, i think
		            'denied' => 'Tipo archivo inválido', // useful, i think
		        ));
	    		}
	    		if($campo->tipo->nombre == 'FotoSimple'){
					echo CHtml::fileField($fieldname, '', array('id'=>$fieldname)).'<br>';
	    		}
	    		echo '</div>';
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