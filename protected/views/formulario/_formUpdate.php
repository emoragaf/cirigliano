<?php
/* @var $this FormularioController */
/* @var $model Formulario */
/* @var $form TbActiveForm */
$titulos = array('Antes'=>array(),'Despues'=>array(),'Acta'=>array(),'General'=>array(),'Otros'=>array());
?>

<div class="form">

    <?php 
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array( 
		'id'=>'formulario-form',
		'enableAjaxValidation'=>false,
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
			    $titulo = str_replace('%n', '', $campo->nombre);
			    if (count($$foo[1])>0) {
				    if ($foo[1] == 'Adicional') {
			    	echo '<h3>Adicionales '.$titulo.'</h3>';
				    }
				    else
				    	echo '<h3>'.$titulo.'</h3>';
			    }
			    foreach ($$foo[1] as $mueble) {
			    		$nombre = $campo->nombre;
			    		//echo $mueble->codigo;
			    	if(strpos($nombre,'%n') !== false){
			    		$id = str_replace('%n', '', $nombre);
			    		//$nombre = str_replace('%n', $mueble->ServicioDescripcion, $nombre);
			    		//$fieldname = 'Foto_'.$id.'['.$mueble->id.']';
			    		$fieldname = 'Foto'.str_replace(' ', '', $id).$mueble->id.'[]';
			    		echo '<div class="well">';
			    		echo '<div class="row">';
			    		foreach ($fotos as $f) {
			    			if ($f->item_foto_id == $mueble->id && strcmp(trim($titulo),$f->tipo->nombre) == 0) {
			    				$url = Yii::app()->assetManager->publish($f->foto->path.$f->foto->id.'.'.$f->foto->extension);
								echo '<div class="span2 well" style="margin:2px; padding-left:auto; padding-right:auto; padding-top:9px; padding-bottom:9px;">';
								echo TbHtml::checkBox('forDelete['.$f->id.']', false, array('value'=>$f->id,'label' => $f->foto->nombre));
								echo'<img src="'.$url.'" style ="max-height:100%; max-width:100%;">';
								echo'</div>';
			    			}
			    		}
			    		echo '</div>';
			    		echo '<h4>'.$mueble->MueblePuntoDescripcion.'</h4>';
			    		echo '<h5>'.$mueble->ServicioDescripcion.'</h5>';
			    		if($campo->tipo->nombre == 'FotoMultiple'){

						    $this->widget('CMultiFileUpload', array(
					            'name' => $fieldname,
					            'id'=>str_replace('[]', '', $fieldname),
					            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
					            'duplicate' => 'Archivo Duplicado!', // useful, i think
					            'denied' => 'Tipo archivo inválido', // useful, i think
					            //'htmlOptions' => array('multiple'=>true),
					            'remove'=>'[x]',
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
				echo '<h3>'.$campo->nombre.'</h3>';
				echo '<div class="well">';
				echo '<div class="row">';
				foreach ($fotos as $f) {
			    			if ($f->item_foto_id == $visita->id && strcmp(trim($campo->nombre),$f->tipo->nombre) == 0) {
			    				$url = Yii::app()->assetManager->publish($f->foto->path.$f->foto->id.'.'.$f->foto->extension);
								echo '<div class="span2 well" style="margin:2px; padding-left:auto; padding-right:auto; padding-top:9px; padding-bottom:9px;">';
								echo TbHtml::checkBox('forDelete['.$f->id.']', false, array('value'=>$f->id,'label' => $f->foto->nombre));
								echo'<img src="'.$url.'" style ="max-height:100%; max-width:100%;">';
								echo'</div>';
			    			}
			    		}
			    echo '</div>';
				$fieldname = str_replace(' ', '', $campo->nombre);
				if($campo->tipo->nombre == 'FotoMultiple'){
					 $this->widget('CMultiFileUpload', array(
		            'name' => $fieldname,
		            'id'=>$fieldname,
		            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
		            'duplicate' => 'Archivo Duplicado!', // useful, i think
		            'denied' => 'Tipo archivo inválido', // useful, i think
		            //'htmlOptions' => array('multiple'=>'multiple'),
		            'remove'=>'[x]',
		        ));
	    		}
	    		if($campo->tipo->nombre == 'FotoSimple'){
					echo CHtml::fileField($fieldname, '', array('id'=>$fieldname)).'<br>';
	    		}
	    		echo '</div>';
			}
		?>
	
	<?php endforeach ?>
	<?php
		if($visita->visita_preventiva == 1){
				echo '<h3>Antes</h3>';
				echo '<div class="well">';
				echo '<div class="row">';
				foreach ($fotos as $f) {
			    			if ($f->tipo_foto_id == 10) {
			    				$url = Yii::app()->assetManager->publish($f->foto->path.$f->foto->id.'.'.$f->foto->extension);
								echo '<div class="span2 well" style="margin:2px; padding-left:auto; padding-right:auto; padding-top:9px; padding-bottom:9px;">';
								echo TbHtml::checkBox('forDelete['.$f->id.']', false, array('value'=>$f->id,'label' => $f->foto->nombre));
								echo'<img src="'.$url.'" style ="max-height:100%; max-width:100%;">';
								echo'</div>';
			    			}
			    		}
			    echo '</div>';
					 $this->widget('CMultiFileUpload', array(
		            'name' => 'VPreventivaAntes[]',
		            'id'=>'VPreventivaAntes',
		            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
		            'duplicate' => 'Archivo Duplicado!', // useful, i think
		            'denied' => 'Tipo archivo inválido', // useful, i think
		            //'htmlOptions' => array('multiple' => true),
		            'remove'=>'[x]',
		        ));
	    		
	    		echo '</div>';

	    		echo '<h3>Despues</h3>';
				echo '<div class="well">';
				echo '<div class="row">';
				foreach ($fotos as $f) {
			    			if ($f->tipo_foto_id == 11) {
			    				$url = Yii::app()->assetManager->publish($f->foto->path.$f->foto->id.'.'.$f->foto->extension);
								echo '<div class="span2 well" style="margin:2px; padding-left:auto; padding-right:auto; padding-top:9px; padding-bottom:9px;">';
								echo TbHtml::checkBox('forDelete['.$f->id.']', false, array('value'=>$f->id,'label' => $f->foto->nombre));
								echo'<img src="'.$url.'" style ="max-height:100%; max-width:100%;">';
								echo'</div>';
			    			}
			    		}
			    echo '</div>';
					 $this->widget('CMultiFileUpload', array(
		            'name' => 'VPreventivaDespues[]',
		            'id'=>'VPreventivaDespues',
		            'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
		            'duplicate' => 'Archivo Duplicado!', // useful, i think
		            'denied' => 'Tipo archivo inválido', // useful, i think
		            //'htmlOptions' => array('multiple' => 'multiple'),
		        ));
	    		
	    		echo '</div>';
			}
	 ?>
        <?php echo $form->textAreaControlGroup($model,'notas',array('rows'=>6,'span'=>8)); ?>

        <div>
        <?php echo TbHtml::submitButton('Aceptar',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->